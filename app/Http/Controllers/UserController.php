<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Models\User;
use App\Services\FCMService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{


    public function register(UserRegisterRequest $request){
        $user = User::create([
            'name'=>$request->name,
            'phone_number'=>$request->phone_number,
            'password'=> Hash::make($request->password)
        ]);
        $token = $user->createToken('token')->plainTextToken;
        return response()->json([
            'token' => $token
        ],201);
    }

    public function login(UserLoginRequest $request){
        $user = User::query()->where('phone_number' , $request->phone_number)->first();
        if($user && Hash::check( $request->password , $user->password )){
            $token = $user->createToken('token')->plainTextToken;
            return response()->json([
                'token' => $token
            ],200);
        }
        else{
            return response()->json([
                'message' => "incorrect credentials"
            ],401);
        }

    }

    public  function logout(){
        auth()->user()->tokens()->delete();
        return response()->json([
            'message' => 'logout successfully'
        ]);
    }
}
