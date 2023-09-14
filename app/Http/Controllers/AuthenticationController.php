<?php

namespace App\Http\Controllers;

use App\CustomResponse\ApiResponse;
use App\Http\Requests\LoginUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\SecurityChecker\Checker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
    use ApiResponse;
    public function login(LoginUserRequest $request){
        try {
//            if (Checker::isParamsFoundInRequest()){
//                return Checker::CheckerResponse();
//            }
            // validate data coming by request
            $request->validated($request->all());

            if (!Auth::attempt($request->only(['email', 'password']))) {
                return response()->json([
                    'status' => false,
                    'message' => 'Email & Password does not match with our record.',
                ], 422);
            }

            $user = User::where('email', $request->email)->first();
            $userAuth = auth()->user();


            return $this->success([
                'token' => $user->createToken("API TOKEN")->plainTextToken,
                'user' => UserResource::make($userAuth),
            ], 'User Login Successfully');

        }catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
