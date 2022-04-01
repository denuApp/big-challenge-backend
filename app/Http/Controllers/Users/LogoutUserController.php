<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use function response;

class LogoutUserController extends Controller
{
    public function __invoke(): JsonResponse
    {
        Auth::user()->tokens()->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Logout Successfully!',
        ]);
    }
}
