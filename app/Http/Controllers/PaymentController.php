<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Request as Transaction;
use App\Models\RequestPayment;
use App\Models\RequestAttachment;
use App\Services\SmsService;
use App\Http\Resources\TransactionResource;

class PaymentController extends Controller
{
    protected $sms;

    public function __construct(SmsService $sms)
    {
        $this->sms = $sms;
    }

    public function store(Request $request){
        if($request->type == 'onsite'){
            RequestPayment::where('request_id',$request->id)->update(['status_id' => 9]);
            Transaction::where('id',$request->id)->update(['status_id' => 16]);
            $data = TransactionResource::collection(
                Transaction::with('comments','log')
                ->with('user.student','type','payment.status','status','attachments')
                ->with('lists.status','lists.document.name','lists.document.type','lists.user.profile')
                ->where('id',$request->id)
                ->get()
            );
        }else{
            $data = $this->upload($request);
            $data = TransactionResource::collection(
                Transaction::with('comments','log')
                ->with('payment.status','status','attachments')
                ->with('lists.status','lists.document.name','lists.document.type','lists.user.profile')
                ->where('user_id',\Auth::user()->id)
                ->get()
            );
        }
        
        if($data){
            $user = Transaction::with('user.student')->where('id',$request->id)->first();
            $content = 'Hi '. $user->user->student->firstname.' '. $user->user->student->lastname.', We have received your payment for the requested documents. Thank you! Registrar office will now process your request.';
            $this->sms->sendSms( $user->user->student->contact_no, $content);
        }
        return response()->json([
            'message' => 'Files uploaded successfully',
            'status' => 15,
            'data' => $data
        ], 200);
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
        Transaction::where('id',$request->id)->update(['status_id' => 16]);
    }
}
