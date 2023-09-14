<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        $users = User::all();
        return UserResource::collection($users);
    }

    public function store(StoreUserRequest $request){
        $request->validated($request->all());
    }
}
