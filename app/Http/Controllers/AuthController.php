<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

class AuthController extends Controller
{
    //
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'fullname' => 'required|string|max:255',
            'display_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'fullname' => $validatedData['fullname'],
            'display_name' => $validatedData['display_name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);
        event(new Registered($user));
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (auth()->attempt($credentials)) {
            return response()->json(['message' => 'OK!', 'user' => auth('sanctum')->user()], 200);
        }

        return response()->json(['message' => 'Invalid email or password.'], 422);
    }

    public function logout(Request $request)
    {
        auth('sanctum')->user->tokens()->delete();
    }

    public function me(Request $request)
    {
        return $request->user();
    }

    public function editProfile()
    {
        return response()->json(['message' => 'ok', 'data' => auth('sanctum')->user()]);
    }
}
