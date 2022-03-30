<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRegistrationRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class RegisterUserController extends Controller
{
    public function __invoke(UserRegistrationRequest $request): JsonResponse
    {
        $request['password'] = Hash::make($request['password']);

        User::create($request->validated());

        return response()->json([
            'status' => 200,
            'message' => 'New user added successfully!',
        ]);
    }
}
