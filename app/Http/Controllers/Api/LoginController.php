<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function __invoke(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'password' => 'required' 
        ]);

        //if validation fails
        if ($validator ->fails()) {
            return response()->json($validator->errors(),422);
        }

        //get credentials from request
        $credentials = $request->only('name','password');

        //if auth failed
        if(!$token = JWTAuth::attempt($credentials)){
            return response()->json([
                'success' => false,
                'message' => 'Username atau Password Anda Salah'
            ],401);
        }

        //if auth success
        return response()->json([
            'success' => true,
            'datauser' => auth()->user(),
            'token' => $token,
        ],200);
    }
}
