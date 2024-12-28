<?php

namespace App\Http\Controllers;

use Spatie\Activitylog\Models\Activity;
use App\Models\AuthenticationLog;
use GuzzleHttp\Client;
use App\Models\Student;
use App\Models\Request as Transaction;
use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\ListDropdown;
use App\Models\RequestList;
use App\Models\RequestPayment;
use App\Models\RequestComment;
use App\Models\RequestAttachment;
use App\Traits\HandlesTransaction;
use App\Http\Resources\TransactionResource;
use App\Http\Resources\StudentResource;
use App\Http\Resources\AuthenticationResource;
use App\Http\Resources\ActivityResource;

class DashboardController extends Controller
{
    use HandlesTransaction;

    public function index(Request $request){
        if(!\Auth::check()){
            return inertia('Auth/Login');
        }else{
            if(\Auth::user()->role == 'Administrator'){
                return inertia('Dashboard/Index',[
                    'authentications' => $this->authentications(),
                    'activities' => $this->activities()
                ]);
            }else if(\Auth::user()->role == 'Student'){
                return inertia('Dashboard/Student',[
                    'lists' => $this->student_lists(),
                    'dropdowns' => [
                        'colleges' => $this->colleges(),
                        'graduates' => $this->graduates(),
                        'types' => $this->types(),
                        'fees' => $this->fees()
                    ]
                ]);
            }else if(\Auth::user()->role == 'Registrar'){
                return inertia('Dashboard/Registrar',[
                    'requests' => $this->registrar(),
                    'students' => $this->students(),
                    'counts' => $this->counts_registrar()
                ]);
            }else{
                return inertia('Dashboard/Staff',[
                    'counts' => $this->counts(),
                    'documents' => [
                        'pending' => $this->pending(),
                        'processing' => $this->processing(),
                        'release' => $this->release()
                    ]
                ]);
            }
        }
    }

    public function store(Request $request){
        switch($request->option){
            case 'receipt':
                $data = $this->upload($request);
                $data = TransactionResource::collection(
                    Transaction::query()
                    ->with('user.student','type','payment.status','status','attachments')
                    ->with('lists.status','lists.document.name','lists.document.type')
                    ->where('user_id',\Auth::user()->id)
                    ->whereIn('status_id',[5,6,13])->orderBy('created_at','DESC')->get()
                );
                return response()->json([
                    'message' => 'Files uploaded successfully',
                    'status' => 15,
                    'data' => $data
                ], 200);
            break;
            case 'request':
                $data = Transaction::with('user.student')->where('id',$request->id)->update(['status_id' => $request->status_id]);
                $data = Transaction::with('user.profile')->where('id',$request->id)->first();
                if($request->status_id == 14){
                    
                    $mobile = $data->user->student->contact_no;
                    $content = 'Hello! Your requested document is ready for pickup. Please visit the Ateneo de Zamboanga University College Registrar\'s Office. Thank you.';
                    $client = new Client();
                 
                    // $result = $client->request('GET', 'https://sgateway.onewaysms.com/apis10.aspx', [
                    //     'query' => [
                    //         'apiusername' => ' 	APIA4J1IDC7IN',
                    //         'apipassword' => 'APIA4J1IDC7INA4J1I',
                    //         'senderid' => 'ONEWAY',
                    //         'mobileno' => $mobile,
                    //         'message' => $content,
                    //         'languagetype' => 1
                    //     ]
                    // ]);
                    // $response = json_decode($result->getBody()->getContents());
                    try {
                        $result = $client->request('GET', 'https://sgateway.onewaysms.com/apis10.aspx', [
                            'query' => [
                                'apiusername' => 'APIPBDOCZMB9Y',  // Use environment variables for security
                                'apipassword' => 'APIPBDOCZMB9YPBDOC',
                                'senderid' => 'ONEWAY',
                                'mobileno' => $mobile,
                                'message' => $content,
                                'languagetype' => 1
                            ]
                        ]);
                    
                        $response = json_decode($result->getBody()->getContents());
                        
                        if ($response) {
                            // Check for any status or error code here
                            // Example: if ($response->status === 'OK') { /* Success logic */ }
                        } else {
                            throw new Exception('Failed to decode the response.');
                        }
                    } catch (RequestException $e) {
                        // Log the error or handle the exception
                        echo 'Request failed: ' . $e->getMessage();
                    }
                }
            break;
            case 'comment': 
                $data = new RequestComment;
                $data->message = $request->message;
                $data->request_id = $request->id;
                $data->save();

                return back()->with([
                    'data' => $data,
                    'message' => 'Comment was added.',
                    'info' => 'You\'ve successfully added a comment.',
                    'status' => true,
                ]);
            break;
            case 'seen':
                $data = RequestComment::where('request_id', $request->id)
                ->update(['is_seened' => 1]);
            break;
            default:
            $data = Transaction::where('id',$request->id)->update(['status_id' => $request->status_id]);
            if($data){
                $total = 0;
                foreach($request->lists as $list){
                    RequestList::where('id',$list['id'])->update([
                        'pages' => $list['pages'],
                        'total' => str_replace(['₱ ', '₱', ',', ' '], '', $list['total'])*$list['pages']
                    ]);
                    $total += str_replace(['₱ ', '₱', ',', ' '], '', $list['total'])*$list['pages'];
                }
                RequestPayment::where('request_id',$request->id)->update(['total' => $total]);
            }
            return back()->with([
                'data' => $data,
                'message' => 'Request was updated.',
                'info' => 'You\'ve successfully updated the request.',
                'status' => true,
            ]);
        }
        
    }

    private function upload($request){
        $request->validate([
            'files.*' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048', // each file must be an image or PDF with max size of 2MB
        ]);
        $uploadedFiles = $request->file('files'); 
        $filePaths = [];

        foreach ($uploadedFiles as $file) {
            $path = $file->store('uploads/receipts', 'public');
            $filePaths[] = $path; 
            $fileSizeInBytes  = $file->getSize();
            if ($fileSizeInBytes >= 1048576) { // If 1 MB or more
                $fileSize = round($fileSizeInBytes / 1048576, 2) . ' MB';
            } else {
                $fileSize = round($fileSizeInBytes / 1024, 2) . ' KB';
            }

            RequestAttachment::create([
                'request_id' => $request->id,
                'file' => $path,
                'size' => $fileSize
            ]);
        }
        RequestPayment::where('request_id',$request->id)->update(['status_id' => 9]);
        Transaction::where('id',$request->id)->update(['status_id' => 6]);

        
        // $name = 'receipt_'.$request->id.'_'.\Auth::user()->id;
        // if($request->hasFile('files'))
        // {   
        //     $files = $request->file('files');   
        //     foreach ($files as $file) {
        //         if($count == 0){
        //             $file_name = strtolower($name).'.'.$file->getClientOriginalExtension();
        //         }else{
        //             $file_name = strtolower($name).'-'.$count.'.'.$file->getClientOriginalExtension();
        //             $count++;
        //         }
        //         $file_path = $file->storeAs('uploads/receipts', $file_name, 'public');

        //         $attachment = [
        //             'name' => $file_name,
        //             'file' => $file_path,
        //             'added_by' => \Auth::user()->id,
        //             'created_at' => date('M d, Y g:i a', strtotime(now()))
        //         ];
        //     }
        //     return $attachment;
        // }
    }

    public function update(Request $request){
        if($request->option == 'request'){
            $data = RequestPayment::where('request_id',$request->id)->update([
                'or_number' => $request->or_number,
                'status_id' => $request->status_id
            ]);
           
            return back()->with([
                'data' => $data,
                'message' => 'Request was updated.',
                'info' => 'You\'ve successfully created new student.',
                'status' => true,
            ]);
        }else{
            $data = RequestList::where('id',$request->id)->update([
                'status_id' => $request->status_id
            ]);
            $data = RequestList::with('status','document.name','document.type')->where('id',$request->id)->first();
            return back()->with([
                'data' => $data,
                'message' => 'Request list was updated.',
                'info' => 'You\'ve successfully updated the list.',
                'status' => true,
            ]);
        }
    }

    private function counts(){
        return [
            [
                "name" => 'Pending Documents',
                'icon' => 'ri-hand-coin-fill',
                'color' => 'text-warning',
                'count' => Transaction::where('status_id',13)->whereHas('payment',function ($query){
                    $query->where('status_id',9);
                })->count()
            ],
            [
                "name" => 'Processing Documents',
                'icon' => 'ri-profile-fill',
                'color' => 'text-info',
                'count' => Transaction::where('status_id',6)->count()
            ],
            [
                "name" => 'For Release Documents',
                'icon' => 'ri-checkbox-fill',
                'color' => 'text-success',
                'count' => Transaction::where('status_id',7)->count()
            ]
        ];
    }

    private function counts_registrar(){
        return [
            [
                "name" => 'Verified Students',
                'icon' => 'ri-group-2-fill',
                'color' => 'text-warning',
                'count' => Student::where('status_id',2)->count()
            ],
            [
                "name" => 'Processing Documents',
                'icon' => 'ri-profile-fill',
                'color' => 'text-info',
                'count' => Transaction::where('status_id',6)->count()
            ],
            [
                "name" => 'Completed Request',
                'icon' => 'ri-checkbox-fill',
                'color' => 'text-success',
                'count' => Transaction::where('status_id',7)->count()
            ]
        ];
    }

    private function cashier(){
        $data = TransactionResource::collection(
            Transaction::query()
            ->with('user.student','type','payment.status','status')
            ->with('lists.status','lists.document.name','lists.document.type')
            ->where('status_id',13)->whereHas('payment',function ($query){
                $query->where('status_id',8);
            })->orderBy('created_at','DESC')->get()
        );
        return $data;
    }

    private function registrar(){
        $data = TransactionResource::collection(
            Transaction::query()
            ->with('user.student','type','payment.status','status','attachments')
            ->with('lists.status','lists.document.name','lists.document.type')
            ->orderBy('created_at','DESC')->get()
        );
        return $data;
    }

    private function pending(){
        $data = TransactionResource::collection(
            Transaction::query()
            ->with('user.student', 'type', 'payment.status', 'status', 'attachments')
            ->with('lists.status', 'lists.document.name', 'lists.document.type')
            ->where('status_id', 6)
            ->whereDoesntHave('lists', function ($query) {
                $query->where('status_id', '!=', 10);
            })
            ->orderBy('created_at', 'DESC')
            ->get()
        );
        return $data;
    }

    private function processing(){
        $data = TransactionResource::collection(
            Transaction::query()
            ->with('user.student','type','payment.status','status','attachments')
            ->with('lists.status','lists.document.name','lists.document.type')
            ->where('status_id',6)
            ->whereHas('lists', function ($query) {
                $query->whereIn('status_id', [11,12]);
            })
            ->orderBy('created_at','DESC')->get()
        );
        return $data;
    }

    private function release(){
        $data = TransactionResource::collection(
            Transaction::query()
            ->with('user.student','type','payment.status','status','attachments')
            ->with('lists.status','lists.document.name','lists.document.type')
            ->where('status_id',7)->orderBy('created_at','DESC')->get()
        );
        return $data;
    }

    private function students(){
        $data = StudentResource::collection(
            Student::query()
            ->with('status','attachments')
            ->where('status_id',15)
            ->orderBy('created_at','DESC')
            ->get()
        );
        return $data;
    }

    private function student_lists(){
        return [
            'requests' => $this->student_request(),
            'histories' => $this->student_history()
        ];
    }

    private function student_request(){
        $data = TransactionResource::collection(
            Transaction::query()
            ->with('comments')
            ->with('user.student','type','payment.status','status','attachments')
            ->with('lists.status','lists.document.name','lists.document.type')
            ->where('user_id',\Auth::user()->id)
            ->whereIn('status_id',[5,6,7,13])->orderBy('created_at','DESC')->get()
        );
        return $data;
    }

    private function student_history(){
        $data = TransactionResource::collection(
            Transaction::query()
            ->with('user.student','type','payment.status','status','attachments')
            ->with('lists.status','lists.document.name','lists.document.type')
            ->where('user_id',\Auth::user()->id)
            ->whereIn('status_id',[14])->orderBy('created_at','DESC')->get()
        );
        return $data;
    }

    private function colleges(){
        $data = Document::with('name','type','fees','addons')->where('type_id',2)->get()->map(function ($item) {
            return [
                'value' => $item->id,
                'name' => $item->name->name,
                'fees' => $item->fees,
                'is_primary' => $item->is_primary,
                'is_perpage' => $item->is_perpage,
                'quantity'=> 1
            ];
        });
        return $data;
    }

    private function graduates(){
        $data = Document::with('name','type','fees','addons')->where('type_id',3)->get()->map(function ($item) {
            return [
                'value' => $item->id,
                'name' => $item->name->name,
                'fees' => $item->fees,
                'is_primary' => $item->is_primary,
                'is_perpage' => $item->is_perpage,
                'quantity'=> 1
            ];
        });
        return $data;
    }

    private function types(){
        $data = ListDropdown::where('classification','Document Type')->get()->map(function ($item) {
            return [
                'value' => $item->id,
                'name' => $item->name
            ];
        });
        return $data;
    }

    private function fees(){
        $data = ListDropdown::where('classification','Fee Type')->get()->map(function ($item) {
            return [
                'value' => $item->id,
                'name' => $item->name,
                'type' => $item->type,
                'others' => $item->others
            ];
        });
        return $data;
    }
    
    public function authentications(){
        $data = AuthenticationLog::orderBy('created_at','DESC')->limit(5)->get();
        return AuthenticationResource::collection($data);
    }

    public function activities(){
        $data = Activity::with('causer.profile')->orderBy('created_at','DESC')->limit(5)->get();
        return ActivityResource::collection($data);
    }
}
