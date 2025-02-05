<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Document;
use App\Models\ListStatus;
use App\Models\ListDropdown;
use Illuminate\Http\Request;
use App\Models\Request as Transaction;
use Spatie\Activitylog\Models\Activity;
use App\Models\AuthenticationLog;
use App\Http\Resources\TransactionResource;
use App\Http\Resources\AuthenticationResource;
use App\Http\Resources\ActivityResource;
use App\Http\Resources\StudentResource;

class HomeController extends Controller
{
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
            }else{
                return inertia('Dashboard/Staff',[
                    'stats' => $this->stats(),
                    'statuses' => $this->statuses(),
                    'reminders' => $this->reminders(),
                    'counts' => $this->counts($this->statuses()),
                    'students' => $this->students(),
                    'procs' => $this->procs(),
                    'dropdowns' => [
                        'colleges' => $this->colleges(),
                        'graduates' => $this->graduates(),
                        'types' => $this->types(),
                        'fees' => $this->fees()
                    ]
                ]);
            }
        }
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

    private function stats(){
        return [
            [
                'name' => 'Pending Requests',
                'description' => 'Awaiting Registrar staff review of Request',
                'count' => Transaction::where('status_id',5)->count(),
                'icon' => 'ri-record-circle-fill fs-20',
                'color' => 'text-warning'
            ],
            [
                'name' => 'Processing Requests',
                'description' => 'Requested documents under the Processing phase',
                'count' => Transaction::whereIn('status_id',[6,7])->count(),
                'icon' => 'ri-play-circle-fill fs-20',
                'color' => 'text-info'
            ],
            [
                'name' => 'Completed',
                'description' => 'Requested documents that finished the End Process',
                'count' => Transaction::where('status_id',13)->count(),
                'icon' => 'ri-checkbox-circle-fill fs-20',
                'color' => 'text-success'
            ]
        ];
    }

    private function procs(){
        return [
            [
                'name' => 'Regular',
                'description' => 'Awaiting Registrar staff review of Request',
                'count' => Transaction::where('is_express',0)->whereIn('status_id',[6,7])->count(),
                'icon' => 'ri-record-circle-fill fs-20',
                'color' => 'text-success'
            ],
            [
                'name' => 'Express',
                'description' => 'Requested documents under the Processing phase',
                'count' => Transaction::where('is_express',1)->whereIn('status_id',[6,7])->count(),
                'icon' => 'ri-record-circle-fill fs-20',
                'color' => 'text-danger'
            ]
        ];
    }

    private function reminders(){
        return [
            [
                'name' => 'For Student Verification',
                'short' => 'Approve student access requests for eligibility',
                'description' => 'Review and approve student access requests to ensure eligibility before granting system access.',
                'count' => Student::where('status_id',15)->count(),
                'icon' => 'ri-group-2-fill',
                'color' => 'bg-info-subtle text-info'
            ],
            [
                'name' => 'Document Requests',
                'short' => 'Record of document requests with status',
                'description' => 'A record of all submitted document requests, showing their status and details for easy tracking.',
                'count' => Transaction::whereIn('status_id',[5,7,16])->count(),
                'icon' => 'ri-file-list-fill',
                'color' => 'bg-danger-subtle text-danger'
            ],
        ];
    }

    public function authentications(){
        $data = AuthenticationLog::orderBy('created_at','DESC')->limit(5)->get();
        return AuthenticationResource::collection($data);
    }

    public function activities(){
        $data = Activity::with('causer.profile')->orderBy('created_at','DESC')->limit(5)->get();
        return ActivityResource::collection($data);
    }

    public function statuses(){
        $data = ListStatus::where('type','Request')->where('is_active',1)->orderBy('step','ASC')->get()->map(function ($item) {
            return [
                'value' => $item->id,
                'name' => ($item->name == 'Confirmed') ? 'For Payment' : $item->name,
                'type' => $item->type,
                'color' => $item->color,
                'others' => $item->others,
            ];
        });
        return $data;
    }

    public function counts($statuses){
        foreach($statuses as $status){
            $counts[] = Transaction::where('status_id',$status['value'])->count();
        }
        return $counts;
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
            ->with('comments','log')
            ->with('user.student','type','payment.status','status','attachments')
            ->with('lists.status','lists.document.name','lists.document.type')
            ->where('user_id',\Auth::user()->id)
            ->whereIn('status_id',[5,6,7,13,16])->orderBy('created_at','DESC')->get()
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
                'subname' => $item->name->subname,
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
                'subname' => $item->name->subname, 
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

}
