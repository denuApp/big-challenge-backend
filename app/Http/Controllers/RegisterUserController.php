<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRegistrationRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class RegisterUserController extends Controller
{
    /**
     * Provision a new web server.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(UserRegistrationRequest $request): JsonResponse
    {
        User::create($request->toArray());

        return response()->json([
            'status' => 200,
            'message' => 'New user added successfully!',
        ]);
    }
}
