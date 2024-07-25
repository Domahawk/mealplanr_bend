<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function create(Request $request): array
    {
        $validated = $request->validate([
            'name' => 'required | string | max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed',
        ]);

        User::factory()->create($validated);

        return [
            'message' => 'User created successfully'
        ];
    }
}
