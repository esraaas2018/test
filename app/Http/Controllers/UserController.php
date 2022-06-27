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
            'email'=>$request->email,
            'password'=> Hash::make($request->password)
        ]);
        $token = $user->createToken('token')->plainTextToken;
        return apiResponse($token);
    }

    public function login(UserLoginRequest $request){
        $user = User::query()->where('email' , $request->email)->first();
        if($user && Hash::check( $request->password , $user->password )){
            $token = $user->createToken('token')->plainTextToken;
            return apiResponse($token);
        }
        else{
            return apiResponse(null,"incorrect credentials",401);
        }

    }

    public  function logout(){
        auth()->user()->tokens()->delete();
        return apiResponse(null,'logout successfully');
    }
}
