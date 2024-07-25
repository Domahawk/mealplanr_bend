<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('LaravelPassportToken');
            return response()->json([
                'token' => $token->accessToken,
                'expiresAt' => Carbon::create($token->token->expires_at)->toCookieString(),
            ], 200);
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    public function logout(Request $request): JsonResponse
    {
        $user = Auth::user()->token();
        $user->revoke();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
}
