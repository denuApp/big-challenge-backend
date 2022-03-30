<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginUserController extends Controller
{
    public function __invoke(UserLoginRequest $request): JsonResponse
    {
        $user = User::where('email', $request['email'])->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Welcome back!',
            'token' => $user->createToken($request['email'])->plainTextToken,
        ]);
    }
}
