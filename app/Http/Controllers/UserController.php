<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    public function index(Request $request){
        switch($request->option){
            case 'lists':
                return $this->lists($request);
            break;
            default: 
                return inertia('Users/Index');
        }
    }

    private function lists($request){
        $data = UserResource::collection(
            User::query()
            ->with('profile')
            ->when($request->type, function ($query, $type) {
                $query->where('status_id',$type);
            })
            ->when($request->keyword, function ($query, $keyword) {
                $query->whereHas('profile',function ($query) use ($keyword) {
                    $query->where(\DB::raw('concat(firstname," ",lastname)'), 'LIKE', "%{$keyword}%")
                    ->orWhere(\DB::raw('concat(lastname," ",firstname)'), 'LIKE', "%{$keyword}%");
                });
            })
            ->where('role','!=','Administrator')
            ->orderBy('created_at','DESC')
            ->paginate($request->count)
        );
        return $data;
    }

    public function store(Request $request){
        $data = User::create(array_merge($request->all(),[
            'password' => bcrypt('123456789'),
            'username' => $request->firstname[0].$request->lastname,
            'is_active' => 1
        ]));
        $data->profile()->create($request->all());
        return back()->with([
            'data' => $data,
            'message' => 'User was created.',
            'info' => 'You\'ve successfully created new user.',
            'status' => true,
        ]);
    }

    public function update(Request $request){
        $data = User::find($request->id);
        $data->email = $request->email;
        $data->role = $request->role;
        if($data->save()){
            $data->profile()->update([
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'middlename' => $request->middlename,
                'mobile' => $request->mobile
            ]);
        }

        return back()->with([
            'data' =>  new UserResource($data),
            'message' => 'User update was successful!', 
            'info' => "You've successfully update user profile.",
            'status' => true
        ]);
    }

}
