<?php

namespace App\Http\Controllers;

use App\Models\Request as Transaction;
use App\Models\DocumentFee;
use Hashids\Hashids;
use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\ListDropdown;
use App\Models\Student;
use App\Services\DropdownService;
use App\Traits\HandlesTransaction;
use Illuminate\Support\Facades\Mail;
use App\Mail\FormSubmissionMail;
use App\Http\Requests\TransactionRequest;

class WelcomeController extends Controller
{
    use HandlesTransaction;
    
    public function __construct(DropdownService $dropdown){
        $this->dropdown = $dropdown;
    }

    public function index(Request $request){
        switch($request->option){
            case 'search':
                return $this->search($request);
            break;
            default:
                return inertia('Welcome',[
                    'colleges' => $this->colleges(),
                    'graduates' => $this->graduates(),
                    'types' => $this->types(),
                    'fees' => $this->fees()
                ]); 
        }
    }

    private function search($request){
        $idnumber = $request->idnumber;
        $data = Student::where('id_number',$idnumber)->first();
        return $data;
    }

    private function colleges(){
        $data = Document::with('name','type','fees','addons')->where('type_id',2)->get()->map(function ($item) {
            return [
                'value' => $item->id,
                'name' => $item->name->name,
                'fees' => $item->fees,
                'is_primary' => $item->is_primary
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
                'is_primary' => $item->is_primary
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

    public function store(TransactionRequest $request){
        $result = $this->handleTransaction(function () use ($request) {
            $data = new Transaction;
            $data->code = 'RGSTR-'.date('m').date('Y').'-'.str_pad((Transaction::count()+1), 4, '0', STR_PAD_LEFT);  
            $data->is_express = ($request->is_express == 4) ? false : true;
            $data->user_id = $request->user_id;
            $data->type_id = $request->type_id;
            $data->status_id = 5;
            if($data->save()){
                $total = 0;
                foreach($request->checked as $list){
                    $document_fee = DocumentFee::where('document_id',$list)->where('type_id',$request->is_express)->first();
                    
                    $data->lists()->create([
                        'quantity' => 1,
                        'fee' => $document_fee->fee,
                        'total' => str_replace(['₱ ', '₱', ',', ' '], '', $document_fee->fee)*1,
                        'status_id' => 10,
                        'document_id' => $list
                    ]);

                    $total += str_replace(['₱ ', '₱', ',', ' '], '', $document_fee->fee);
                }

                foreach($request->others as $list){
                    $document_fee = DocumentFee::where('document_id',$list)->where('type_id',$request->is_express)->first();
                    
                    $data->lists()->create([
                        'quantity' => 1,
                        'fee' => $document_fee->fee,
                        'total' => str_replace(['₱ ', '₱', ',', ' '], '', $document_fee->fee)*1,
                        'status_id' => 10,
                        'document_id' => $list
                    ]);

                    $total += str_replace(['₱ ', '₱', ',', ' '], '', $document_fee->fee);
                }
                
                $data->payment()->create([
                    'total' => $total,
                    'status_id' => 8,
                ]);

                return [
                    'data' => $data,
                    'message' => 'Your request was completed successfully!', 
                    'info' => "We will call you for confirmation. Thank you for choosing us.",
                    'status' => true
                ];
            }else{
                return [
                    'data' => '',
                    'message' => 'Your request is not processed!', 
                    'info' => "There is an error on submitting the request.",
                    'status' => false
                ];
            }
        });

        return back()->with([
            'data' => $result['data'],
            'message' => $result['message'],
            'info' => $result['info'],
            'status' => $result['status'],
        ]);

    }

    // public function store(CustomerRequest $request){
    //     $result = $this->handleTransaction(function () use ($request) {
    //         $data = Customer::create(array_merge($request->all(),[
    //             'reserved_at' => $request->date.' '.$request->time,
    //             'status_id' => 1
    //         ]));
    //         if($data){
    //             $ip = $request->ip();
    //             $data->log()->create([
    //                 'ip_address' => $ip,
    //                 'user_agent' => $request->userAgent(),
    //                 'location' => json_encode(geoip()->getLocation($ip)->toArray()),
    //             ]);
    //         }
    //         return [
    //             'data' => $data,
    //             'message' => 'Your booking was completed successfully!', 
    //             'info' => "We will call you for confirmation. Thank you for choosing us."
    //         ];
    //     });

    //     return back()->with([
    //         'data' => $result['data'],
    //         'message' => $result['message'],
    //         'info' => $result['info'],
    //         'status' => $result['status'],
    //     ]);
    // }
}
