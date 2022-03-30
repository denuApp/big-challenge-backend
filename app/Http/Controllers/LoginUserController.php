<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class LoginUserController extends Controller
{
    public function __invoke(UserLoginRequest $request): JsonResponse
    {
        //$user = User::where('email', '=', $request['email'])->first();

//        if (isset($user)) {
//            if ($user->password === $request['password']) {
//                return response()->json([
//                    'status' => 200,
//                    'message' => 'Welcome back!',
//                ]);
//            } else {
//                return response()->json([
//                    'status' => 200,
//                    'message' => 'Wrong email or password!',
//                ]);
//            }
//        } else {
//            return response()->json([
//                'status' => 200,
//                'message' => 'Wrong email or password!',
//            ]);
//        }

        $user = User::where('email', $request['email'])->first();

        if (! $user || ! ($request['password'] === $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Welcome back!',
            'token' => $user->createToken($request['email'])->plainTextToken,
        ]);

//        return response()->json([
//            'status' => 200,
//            'message' => 'Wrong email or password!',
//            'token' => $user->createToken($request['email'])->plainTextToken
//        ]);
    }
}
