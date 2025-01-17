<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\ListStatus;
use App\Models\ListDropdown;
use Illuminate\Http\Request;
use App\Models\Request as Transaction;
use App\Http\Resources\TransactionResource;

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
                    'statuses' => $this->statuses(),
                    'counts' => $this->counts($this->statuses())
                ]);
            }
        }
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

}
