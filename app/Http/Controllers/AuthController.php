<?php

namespace App\Http\Controllers;

use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Log\Logger;
use Log;

class AuthController extends Controller
{
    
    public function register(Request $request){
       $fileds=$request->validate([
        'name'=>"required|max:255",
        "email"=> "required|email|unique:users",
        "password"=> "required|confirmed"
       ]);
       $user = User::create($fileds);
       $token=$user->createToken($request->name)->plainTextToken;
    return [
        'user'=> $user,
        'token'=> $token
    ];
    }
    public function login (Request $request){
     $field=$request->validate([
        "email"=>'required|email|exists:users',
        'password'=> 'required'
     ]);
    $user=User::where('email',$request->email)->first();
    if (!$user||!Hash::check($request->password,$user->password)) {
        return [
            'message'=>'The provided credentials are incorrect '
        ];

    
    }
    $token = $user->createToken($user->name )->plainTextToken;
    return [
        'user'=> $user,
        'token'=> $token
    ];
}
    public function logout(Request $request){
    $request->user()->tokens()->delete();
    }

}
