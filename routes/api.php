<?php

use App\Http\Controllers\Email\ResendingEmailController;
use App\Http\Controllers\Email\VerifyEmailController;
use App\Http\Controllers\Email\VerifyEmailHandlerController;
use App\Http\Controllers\Submissions\DeleteSubmissionsController;
use App\Http\Controllers\Submissions\EditSubmissionsController;
use App\Http\Controllers\Submissions\GetSubmissionsController;
use App\Http\Controllers\Submissions\StoreSubmissionsController;
use App\Http\Controllers\Users\LoginUserController;
use App\Http\Controllers\Users\LogoutUserController;
use App\Http\Controllers\Users\PatientInformationController;
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
Route::middleware('auth:sanctum')->post('store-information', PatientInformationController::class);

//Route::get('verify-email', VerifyEmailController::class)->middleware('auth')->name('verification.notice');
Route::get('verify-email/{id}/{hash}', VerifyEmailHandlerController::class)->name('verification.verify');
Route::post('email-verification-notification', ResendingEmailController::class)->name('verification.send');

Route::middleware('auth:sanctum')->post('store-submissions', StoreSubmissionsController::class);
Route::middleware('auth:sanctum')->get('get-submissions', GetSubmissionsController::class);
Route::middleware(['auth:sanctum'])->delete('delete-submission/{submission}', DeleteSubmissionsController::class);
Route::middleware(['auth:sanctum'])->patch('edit-submission/{submission}', EditSubmissionsController::class);
