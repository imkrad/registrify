<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Validation\Rule;
use App\Models\Student;
use App\Models\ListStatus;
use Illuminate\Http\Request;
use App\Services\SmsService;
use App\Http\Requests\StudentRequest;
use App\Http\Resources\StudentResource;

class StudentController extends Controller
{
    protected $sms;

    public function __construct(SmsService $sms)
    {
        $this->sms = $sms;
    }

    public function index(Request $request){
        switch($request->option){
            case 'lists':
                return $this->lists($request);
            break;
            case 'students':
                return $this->students($request);
            break;
            default: 
                return inertia('Students/Index',[
                    'statuses' => $this->statuses(),
                ]);
        }
    }

    private function students($request){
        $data = Student::with('user')
        ->when($request->keyword, function ($query, $keyword) {
            $query->where(function($query) use ($keyword) {
                $query->where(\DB::raw('concat(firstname," ",lastname)'), 'LIKE', "%{$keyword}%")
                ->orWhere(\DB::raw('concat(lastname," ",firstname)'), 'LIKE', "%{$keyword}%")
                ->orWhere('id_number', 'LIKE', "%{$keyword}%");
            });
        })
        ->where('status_id',2)
        ->limit(5)->get()->map(function ($item) {
            return [
                'value' => $item->user->id,
                'id_number' => $item->id_number,
                'name' => $item->firstname.' '.$item->lastname.' ('.$item->id_number.')',
            ];
        });
        return $data;
    }

    private function lists($request){
        $data = StudentResource::collection(
            Student::query()
            ->with('status')
            ->with('attachments')
            ->when($request->type, function ($query, $type) {
                $query->where('status_id',$type);
            })
            ->orderBy('created_at','DESC')
            ->paginate($request->count)
        );
        return $data;
    }

    private function statuses(){
        $data = ListStatus::where('type','Student')->get()->map(function ($item) {
            return [
                'value' => $item->id,
                'name' => $item->name,
                'color' => $item->color,
                'others' => $item->others
            ];
        });
        return $data;
    }

    public function store(StudentRequest $request){
        $data = Student::create(array_merge($request->all(),['status_id' => 1]));
        return back()->with([
            'data' => $data,
            'message' => 'Student was created.',
            'info' => 'You\'ve successfully created new student.',
            'status' => true,
        ]);
    }

    public function update(Request $request){
        
        $request->validate([
            'firstname' => 'sometimes|required',
            'lastname' => 'sometimes|required',
            'middlename' => 'sometimes|required',
            'sex' => 'sometimes|required',
            'email' => 'sometimes|required',
            'contact_no' => 'sometimes|required',
            'id_number' => ['sometimes','required',Rule::unique('students', 'id_number')->ignore($request->id)]
        ]);

        if($request->status){
            $data = Student::where('id',$request->id)->update(['status_id' => $request->status]);
            $data = Student::where('id',$request->id)->first();
            $content = 'Hi '.$data->firstname.' '.$data->lastname.', Your access has been granted! You are now verified as a student of Ateneo de Zamboanga University and can use the system. Welcome!';
            $this->sms->sendSms($data->contact_no, $content);
        }else{    
            $data = Student::where('id',$request->id)->first();
            $data->contact_no = $request->contact_no;
            $data->email = $request->email;
            $data->firstname = $request->firstname;
            $data->middlename = $request->middlename;
            $data->lastname = $request->lastname;
            $data->sex = $request->sex;
            $data->id_number = $request->id_number;
            $data->save();
        }
        $data = Student::with('status')->where('id',$request->id)->first();
        return back()->with([
            'data' =>  new StudentResource($data),
            'message' => 'Student update was successful!', 
            'info' => "You've successfully update user profile.",
            'status' => true
        ]);
    }
}
