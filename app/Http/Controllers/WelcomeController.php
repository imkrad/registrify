<?php

namespace App\Http\Controllers;

use Hashids\Hashids;
use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\ListDropdown;
use App\Services\DropdownService;
use App\Traits\HandlesTransaction;
use Illuminate\Support\Facades\Mail;
use App\Mail\FormSubmissionMail;

class WelcomeController extends Controller
{
    use HandlesTransaction;
    
    public function __construct(DropdownService $dropdown){
        $this->dropdown = $dropdown;
    }

    public function index(Request $request){
        return inertia('Welcome',[
            'colleges' => $this->colleges(),
            'graduates' => $this->graduates(),
            'types' => $this->types()
        ]); 
    }

    private function colleges(){
        $data = Document::with('name','type','fees','addons')->where('type_id',2)->get();
        return $data;
    }

    private function graduates(){
        $data = Document::with('name','type','fees','addons')->where('type_id',3)->get();
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
