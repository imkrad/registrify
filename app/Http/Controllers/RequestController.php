<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Request as Transaction;
use App\Models\RequestLog;
use App\Models\RequestList;
use App\Models\RequestPayment;
use App\Models\RequestComment;
use App\Models\DocumentFee;
use Illuminate\Http\Request;
use App\Services\SmsService;
use App\Http\Requests\TransactionRequest;
use App\Http\Resources\TransactionResource;

class RequestController extends Controller
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
            case 'print':
                return $this->print($request);
            break;
            default: 
                return inertia('Requests/Index');
        }
    }

    public function update(Request $request){
        $data = RequestList::where('id',$request->id)->update([
            'status_id' => $request->status_id,
            'user_id' => \Auth::user()->id
        ]);
        $data = RequestList::with('status','document.name','document.type','user.profile')->where('id',$request->id)->first();
        return back()->with([
            'data' => $data,
            'message' => 'Document processing has '.($request->status_id == 11) ? 'started' : 'been completed',
            'info' => 'You\'ve successfully updated the list.',
            'status' => true,
        ]);
    }

    public function store(Request $request){
        switch($request->type){
            case 'confirm':
                $data = Transaction::with('user.student')->where('id',$request->id)->update([
                    'status_id' => 6
                ]);
                if($data){
                    $total = 0;
                    foreach($request->lists as $list){
                        if(count($list['document']['addons']) > 0){
                            $subtotal = 0;
                            foreach($list['document']['addons'] as $addon){
                                $subtotal += str_replace(['₱ ', '₱', ',', ' '], '', $addon['fee']);
                            }
                            $subtotal = $list['quantity']*$subtotal;
                        }else{
                            $subtotal = 0;
                        }
                        RequestList::where('id',$list['id'])->update([
                            'pages' => $list['pages'],
                            'total' => str_replace(['₱ ', '₱', ',', ' '], '', $list['total'])*$list['pages']
                        ]);
                        
                        $total += str_replace(['₱ ', '₱', ',', ' '], '', $list['total'])*$list['pages'];
                        $total = $total + $subtotal;
                    }
                    RequestPayment::where('request_id',$request->id)->update(['total' => $total]);
                    RequestLog::create([
                        'prepared_by' => \Auth::user()->id,
                        'prepared_date' => now(),
                        'request_id' => $request->id
                    ]);
                    $student = Transaction::with('user.student')->where('id',$request->id)->first();
                    $content = 'Hi '.$student->user->student->firstname.' '.$student->user->student->lastname.', Your request for documents has been confirmed and is now ready for payment. Please upload the receipt to the system once payment is made. Thank you!';
                    $this->sms->sendSms($student->user->student->contact_no, $content);

                    $data = Transaction::with('user.student','type','payment.status','status','comments.user.profile','authorization')
                    ->with('lists.status','lists.document.name','lists.document.type','lists.user.profile')->where('id',$request->id)->first();
                }
            break;
            case 'process':
                $data = Transaction::where('id',$request->id)->first();
                $is_express = $data->is_express;
                $currentDate = Carbon::now();
                if($is_express){
                    $calculatedDate = $currentDate->addDays(3);
                }else{
                    $calculatedDate = $currentDate->addDays(7);
                }
                $data = Transaction::where('id',$request->id)->update(['status_id' => 7, 'due_at' => $calculatedDate]);
                if($data){
                    RequestLog::where('request_id',$request->id)->update(['processed_by' => \Auth::user()->id,'processed_date' => now(),]);
                    $data = Transaction::with('user.student','type','payment.status','status','comments.user.profile','authorization')
                    ->with('lists.status','lists.document.name','lists.document.type','lists.user.profile')->where('id',$request->id)->first();
                }
            break;
            case 'completed':
                $data = Transaction::with('user.student')->where('id',$request->id)->update([ 'status_id' => 13]);
                if($data){
                    RequestLog::where('request_id',$request->id)->update(['completed_by' => \Auth::user()->id,'completed_date' => now(),]);
                    $data = Transaction::with('user.student','type','payment.status','status','comments.user.profile','authorization')
                    ->with('lists.status','lists.document.name','lists.document.type','lists.user.profile')->where('id',$request->id)->first();
                    $student = Transaction::with('user.student')->where('id',$request->id)->first();
                    $content = 'Hi '.$student->user->student->firstname.' '.$student->user->student->lastname.', Your requested document is ready for pickup. Please visit the Ateneo de Zamboanga University College Registrar\'s Office. Thank you.';
                    $this->sms->sendSms($data->user->student->contact_no, $content);
                }
            break;
            case 'release':
                $data = Transaction::where('id',$request->id)->update(['status_id' => 14, 'claimed_at' => now()]);
                if($data){
                    RequestLog::where('request_id',$request->id)->update(['released_by' => \Auth::user()->id,'released_date' => now(),]);
                    $data = Transaction::with('user.student','type','payment.status','status','comments.user.profile','authorization')
                    ->with('lists.status','lists.document.name','lists.document.type','lists.user.profile')->where('id',$request->id)->first();

                    $content = 'Hi '.$data->user->student->firstname.' '.$data->user->student->lastname.', Your requested document has been released. It is now available for your use. Thank you!';
                    $this->sms->sendSms($data->user->student->contact_no, $content);
                }
            break;
            case 'comment': 
                $data = new RequestComment;
                $data->message = $request->message;
                $data->request_id = $request->id;
                $data->user_id = \Auth::user()->id;
                $data->save();

                $data = Transaction::with('user.student','type','payment.status','status','comments.user.profile','authorization')->with('lists.status','lists.document.name','lists.document.type','lists.user.profile')->where('id',$request->id)->first();
               
                $content = 'Hello '.$data->user->student->firstname.' '.$data->user->student->lastname.', your account has received a new comment from the registrar. Please log in to your account to view the details. Thank you!';
                $this->sms->sendSms($data->user->student->contact_no, $content);
            break;
        }

        return back()->with([
            'data' => new TransactionResource($data),
            'message' => 'Request was updated.',
            'info' => 'You\'ve successfully updated the request.',
            'status' => true,
        ]);
    }

    private function lists($request){
        $data = TransactionResource::collection(
            Transaction::query()
            ->with('user.student','type','payment.status','status','comments.user.profile','authorization')
            ->with('log.prepared.profile','log.processed.profile','log.completed.profile','log.released.profile')
            ->with('lists.status','lists.document.name','lists.document.addons.lists.name','lists.document.type','lists.user.profile')
            ->when($request->status, function ($query, $status) {
                $query->where('status_id', $status);
            })
            ->when($request->keyword, function ($query, $keyword) {
                $query->where('code', 'LIKE', "%{$keyword}%");
                $query->orWhereHas('user',function ($query) use ($keyword) {
                    $query->whereHas('student',function ($query) use ($keyword) {
                        $query->where(\DB::raw('concat(firstname," ",lastname)'), 'LIKE', "%{$keyword}%")
                        ->orWhere(\DB::raw('concat(lastname," ",firstname)'), 'LIKE', "%{$keyword}%");
                    });
                });
            })
            ->orderBy('created_at','DESC')
            ->paginate($request->count)
        );
        return $data;
    }

    private function print($request){
        $id = $request->id;
        $data = Transaction::where('id',$id)
        ->with('log.prepared.profile')
        ->with('user.student','type','payment','status')
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
