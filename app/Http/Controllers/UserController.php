<?php

namespace App\Http\Controllers;

use App\CustomResponse\ApiResponse;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use ApiResponse;
    public function index(){
        $users = User::all();
        return UserResource::collection($users);
    }

    public function store(StoreUserRequest $request){
        $request->validated($request->all());
        $user = User::create($request->all());
        return UserResource::make($user);
    }

    public function update(UpdateUserRequest $request , User $user){
        $request->validated($request->all());
        $user->update($request->all());
        return UserResource::make($user);
    }

    public function destroy(User $user){
        $user->delete();
        return $this->success($user , 'User Deleted Successfully From Our System');
    }
}
