<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RegisterRequest;

class RegisterController extends Controller
{
    public function store(RegisterRequest $request){
        $user = User::create([
            'email' => $request->email,
            'username' => $request->email,
            'password' => Hash::make($request->password),
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
                Auth::login($user);

                return redirect(route('dashboard', absolute: false));
            }
        }


    }
}
