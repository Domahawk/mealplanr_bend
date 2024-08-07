<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidInputException;
use App\Http\Requests\AuthRequest;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * @throws InvalidInputException
     */
    public function login(AuthRequest $request): JsonResponse
    {
        $credentials = $request->validated();

        if (!Auth::attempt($credentials)) {
            throw new InvalidInputException('Invalid credentials', 401);
        }

        $user = Auth::user();
        $token = $user->createToken('LaravelPassportToken');
        return response()->json([
            'token' => $token->accessToken,
            'expiresAt' => Carbon::create($token->token->expires_at)->toCookieString(),
        ], 200);
    }

    public function logout(): JsonResponse
    {
        $user = Auth::user()->token();
        $user->revoke();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
}
