<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            return response()->json([
                'message' => 'Email atau password salah.',
            ], 401);
        }

        $token = Str::random(80);
        $user->forceFill(['api_token' => $token])->save();

        return response()->json([
            'message' => 'Login berhasil.',
            'token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->forceFill(['api_token' => null])->save();

        return response()->json([
            'message' => 'Logout berhasil.',
        ]);
    }

    public function checkToken(Request $request)
    {
        return response()->json([
            'valid' => true,
            'user' => $request->user(),
        ]);
    }
}
