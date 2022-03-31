<?php

use App\Http\Controllers\LoginUserController;
use App\Http\Controllers\LogoutUserController;
use App\Http\Controllers\RegisterUserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('register-user', RegisterUserController::class);
Route::post('login-user', LoginUserController::class);
Route::middleware('auth:sanctum')->post('logout-user', LogoutUserController::class);
