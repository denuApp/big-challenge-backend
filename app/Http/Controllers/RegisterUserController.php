<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRegistrationRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;

class RegisterUserController extends Controller
{
    public function __invoke(UserRegistrationRequest $request): UserResource
    {
        $request['password'] = Hash::make($request['password']);

        $user = User::create($request->validated());

        $user->assignRole($request['roles']);

        event(new Registered($user));

        return new UserResource($user);
    }
}
