<?php

namespace App\Http\Controllers;

use App\Models\Request as Transaction;
use App\Models\DocumentFee;
use Illuminate\Http\Request;
use App\Http\Requests\TransactionRequest;
use App\Http\Resources\TransactionResource;

class RequestController extends Controller
{
    public function index(Request $request){
        switch($request->option){
            case 'lists':
                return $this->lists($request);
            break;
            case 'print':
                return $this->print($request);
            break;
            default: 
                return inertia('Requests/Index');
        }
    }

    private function lists($request){
        $data = TransactionResource::collection(
            Transaction::query()
            ->with('student','type','payment','status')
            ->with('lists.status','lists.document.name','lists.document.type')
            // ->when($request->keyword, function ($query, $keyword) {
            //     $query->whereHas('name',function ($query) use ($keyword) {
            //         $query->where('name', 'LIKE', "%{$keyword}%");
            //     });
            // })
            ->orderBy('created_at','DESC')
            ->paginate($request->count)
        );
        return $data;
    }

    private function print($request){
        $id = $request->id;
        $data = Transaction::where('id',$id)
        ->with('student','type','payment','status')
        ->with('lists.status','lists.document.name','lists.document.type')
        ->first();
        $array = [
            'data' => $data
        ];
        $width = 10 * 28.35; 
        $height = 13 * 28.35; 
        $pdf = \PDF::loadView('prints.slip',$array)->setPaper([0, 0, $width, $height], 'portrait');

        return $pdf->stream('paymentslip.pdf');
    }
    
}
