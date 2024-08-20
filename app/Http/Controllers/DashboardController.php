<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\HandlesTransaction;

class DashboardController extends Controller
{
    use HandlesTransaction;

    public function index(Request $request){
        if(!\Auth::check()){
            return inertia('Auth/Login');
        }else{
            return inertia('Dashboard/Index');
        }
    }
}
