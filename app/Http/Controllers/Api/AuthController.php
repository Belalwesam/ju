<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\LoginUserRequest;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\RegisterUserRequest;

class AuthController extends Controller
{
    public function register(RegisterUserRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        $token = Auth::login($user);
        return response()->json([
            'message' => 'user created succesfully',
            'user' => $user,
            'token' => $token
        ]);
    }
    public function login(LoginUserRequest $request)
    {
        $token = Auth::attempt($request->only('email', 'password'));

        if (!$token) {
            return response()->json([
                'message' => 'please check your credentials'
            ], 401);
        }
        $user = Auth::user();
        return response()->json([
            'message' => 'logged in successfully',
            'user' => $user,
            'token' => $token
        ]);
    }
}
