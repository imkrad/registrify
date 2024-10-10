<?php

namespace App\Http\Controllers;

use App\Models\Request as Transaction;
use Illuminate\Http\Request;
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

    private function counts(){
        return [
            [
                "name" => 'Pending Documents',
                'icon' => 'ri-hand-coin-fill',
                'color' => 'text-warning',
                'count' => Transaction::where('status_id',5)->count()
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

    private function pending(){
        $data = TransactionResource::collection(
            Transaction::query()
            ->with('student','type','payment','status')
            ->with('lists.status','lists.document.name','lists.document.type')
            ->where('status_id',5)->orderBy('created_at','DESC')->get()
        );
        return $data;
    }

    private function processing(){
        $data = TransactionResource::collection(
            Transaction::query()
            ->with('student','type','payment','status')
            ->with('lists.status','lists.document.name','lists.document.type')
            ->where('status_id',6)->orderBy('created_at','DESC')->get()
        );
        return $data;
    }

    private function release(){
        $data = TransactionResource::collection(
            Transaction::query()
            ->with('student','type','payment','status')
            ->with('lists.status','lists.document.name','lists.document.type')
            ->where('status_id',7)->orderBy('created_at','DESC')->get()
        );
        return $data;
    }
}
