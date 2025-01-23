<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Services\SmsService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RegisterRequest;

class RegisterController extends Controller
{
    protected $sms;

    public function __construct(SmsService $sms)
    {
        $this->sms = $sms;
    }

    public function store(RegisterRequest $request){
        $user = User::create([
            'email' => $request->email,
            'username' => $request->email,
            'password' => Hash::make($request->password),
            'is_active' => 1,
            'email_verified_at' => now(),
            'role' => 'Student'
        ]);
        if($user){
            $student = Student::create(
                array_merge($request->all(),[
                    'status_id' => 1,
                    'user_id' => $user->id
                ])
            );
            if($student){
                $content = 'Hi '.$request->firstname.' '.$request->lastname.', Your registration is complete. Your request is now awaiting approval from the university. You will be notified once access to the system is granted.';
                $this->sms->sendSms($request->contact_no, $content);
                Auth::login($user);

                return redirect(route('dashboard', absolute: false));
            }
        }


    }
}
