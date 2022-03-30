<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class LoginUserController extends Controller
{
    public function __invoke(UserLoginRequest $request): JsonResponse
    {
        $user = User::where('email', '=', $request['email'])->first();

        if (isset($user)) {
            if ($user->password === $request['password']) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Welcome back!',
                ]);
            } else {
                return response()->json([
                    'status' => 200,
                    'message' => 'Wrong email or password!',
                ]);
            }
        } else {
            return response()->json([
                'status' => 200,
                'message' => 'Wrong email or password!',
            ]);
        }
    }
}
