<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\TransactionRequest;

class RequestController extends Controller
{
    public function index(Request $request){
        switch($request->option){
            case 'lists':
                return [];
            break;
            default: 
                return inertia('Requests/Index');
        }
    }

    public function store(TransactionRequest $request){

    }
}
