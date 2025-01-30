<?php

namespace App\Http\Controllers;

use App\Models\Request as Transaction;
use App\Models\RequestAuthorization;
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
use App\Http\Resources\TransactionResource;
use App\Events\NotificationEvent;

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
            $lists = $request->checked;
            $data = new Transaction;
            $data->code = 'RGSTR-'.date('m').date('Y').'-'.str_pad((Transaction::count()+1), 4, '0', STR_PAD_LEFT);  
            $data->is_express = ($request->is_express == 4) ? false : true;
            $data->is_personal = $request->is_personal;
            $data->user_id = $request->user_id;
            $data->type_id = $request->type_id;
            $data->purpose = $request->purpose;
            $data->status_id = 5;
            if($data->save()){
                $total = 0;
                $checked = $request->input('checked', []);
                $lists = array_map(function ($item) {
                return json_decode($item, true); 
                }, $checked);
                foreach($lists[0] as $list){
                    $document_fee = DocumentFee::where('document_id',$list['value'])->where('type_id',$request->is_express)->first();

                    $data->lists()->create([
                        'quantity' => (int) $list['quantity'],
                        'fee' => $document_fee->fee,
                        'total' => str_replace(['₱ ', '₱', ',', ' '], '', $document_fee->fee)*(int) $list['quantity'],
                        'status_id' => 10,
                        'document_id' => $list['value']
                    ]);
                    $total += str_replace(['₱ ', '₱', ',', ' '], '', $document_fee->fee)*(int) $list['quantity'];
                }
                $lists = $request->others;
                $others = $request->input('others', []);
                $lists = array_map(function ($item) {
                return json_decode($item, true); 
                }, $others);
                foreach($lists as $list){
                    if($list){
                        $document_fee = DocumentFee::where('document_id',$list)->where('type_id',$request->is_express)->first();
                        
                        $data->lists()->create([
                            'quantity' => (int) $list['quantity'],
                            'fee' => $document_fee->fee,
                            'total' => str_replace(['₱ ', '₱', ',', ' '], '', $document_fee->fee)*(int) $list['quantity'],
                            'status_id' => 10,
                            'document_id' => $list['value']
                        ]);

                        $total += str_replace(['₱ ', '₱', ',', ' '], '', $document_fee->fee)*(int) $list['quantity'];
                    }
                }
                
                $data->payment()->create([
                    'total' => $total,
                    'status_id' => 8,
                ]);

                $transaction = new TransactionResource(
                    Transaction::query()
                    ->with('user.student','type','payment.status','status','comments.user.profile','authorization')
                    ->with('log.prepared.profile','log.processed.profile','log.completed.profile','log.released.profile')
                    ->with('lists.status','lists.document.name','lists.document.type','lists.user.profile')
                    ->where('id',$data->id)
                    ->first()
                );
                broadcast(new NotificationEvent($transaction,'documnet'));

                if(!$request->is_personal){
                    $this->upload($request,$data->id);
                }

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

    private function upload($request,$id){
        $request->validate([
            'files.*' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048', // each file must be an image or PDF with max size of 2MB
        ]);
        $uploadedFiles = $request->file('files'); 
        $filePaths = [];

        foreach ($uploadedFiles as $file) {
            $path = $file->store('uploads/authorizations', 'public');
            $filePaths[] = $path; 
            $fileSizeInBytes  = $file->getSize();
            if ($fileSizeInBytes >= 1048576) { // If 1 MB or more
                $fileSize = round($fileSizeInBytes / 1048576, 2) . ' MB';
            } else {
                $fileSize = round($fileSizeInBytes / 1024, 2) . ' KB';
            }

            RequestAuthorization::create([
                'request_id' => $id,
                'name' => $request->name,
                'file' => $path,
                'size' => $fileSize
            ]);
        }
    }
}
