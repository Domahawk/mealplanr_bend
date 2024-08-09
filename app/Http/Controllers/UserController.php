<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function store(UserRequest $request): array
    {
        $validated = $request->validated();

        User::create($validated);

        return [
            'message' => 'User created successfully'
        ];
    }
}
