<?php

use App\Http\Controllers\Email\ResendingEmailController;
use App\Http\Controllers\Email\VerifyEmailController;
use App\Http\Controllers\Email\VerifyEmailHandlerController;
use App\Http\Controllers\Users\LoginUserController;
use App\Http\Controllers\Users\LogoutUserController;
use App\Http\Controllers\Users\RegisterUserController;
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
Route::get('verify-email', VerifyEmailController::class)->middleware('auth')->name('verification.notice');
Route::get('verify-email/{id}/{hash}', VerifyEmailHandlerController::class)->middleware(['auth', 'signed'])->name('verification.verify');
Route::post('email-verification-notification', ResendingEmailController::class)->middleware(['auth', 'throttle:6,1'])->name('verification.send');
