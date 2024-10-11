<?php

namespace App\Http\Controllers;

use App\Models\Request as Transaction;
use Illuminate\Http\Request;
use App\Models\RequestList;
use App\Models\RequestPayment;
use App\Traits\HandlesTransaction;
use App\Http\Resources\TransactionResource;

class DashboardController extends Controller
{
    use HandlesTransaction;

    public function index(Request $request){
        if(!\Auth::check()){
            return inertia('Auth/Login');
        }else{
            if(\Auth::user()->role == 'Administrator'){
                return inertia('Dashboard/Index');
            }else if(\Auth::user()->role == 'Cashier'){
                return inertia('Dashboard/Cashier',[
                    'requests' => $this->cashier()
                ]);
            }else if(\Auth::user()->role == 'Registrar'){
                return inertia('Dashboard/Registrar',[
                    'requests' => $this->registrar()
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
        $data = Transaction::where('id',$request->id)->update(['status_id' => $request->status_id]);
        return back()->with([
            'data' => $data,
            'message' => 'Request was updated.',
            'info' => 'You\'ve successfully created new student.',
            'status' => true,
        ]);
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

    private function cashier(){
        $data = TransactionResource::collection(
            Transaction::query()
            ->with('student','type','payment.status','status')
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
            ->with('student','type','payment.status','status')
            ->with('lists.status','lists.document.name','lists.document.type')
            ->where('status_id',5)->orderBy('created_at','DESC')->get()
        );
        return $data;
    }

    private function pending(){
        $data = TransactionResource::collection(
            Transaction::query()
            ->with('student','type','payment.status','status')
            ->with('lists.status','lists.document.name','lists.document.type')
            ->where('status_id',13)->whereHas('payment',function ($query){
                $query->where('status_id',9);
            })->orderBy('created_at','DESC')->get()
        );
        return $data;
    }

    private function processing(){
        $data = TransactionResource::collection(
            Transaction::query()
            ->with('student','type','payment.status','status')
            ->with('lists.status','lists.document.name','lists.document.type')
            ->where('status_id',6)->orderBy('created_at','DESC')->get()
        );
        return $data;
    }

    private function release(){
        $data = TransactionResource::collection(
            Transaction::query()
            ->with('student','type','payment.status','status')
            ->with('lists.status','lists.document.name','lists.document.type')
            ->where('status_id',7)->orderBy('created_at','DESC')->get()
        );
        return $data;
    }
}
