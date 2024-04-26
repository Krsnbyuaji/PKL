<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Jika autentikasi berhasil
            return response()->json(['success' => true, 'message' => 'Login berhasil']);
        }

        // Jika autentikasi gagal
        return response()->json(['success' => false, 'message' => 'Email atau Password Anda Salah'], 401);
    }
}
