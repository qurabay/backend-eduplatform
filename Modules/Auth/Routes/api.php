<?php

use Illuminate\Support\Facades\Route;
use Modules\Auth\Http\Controllers\RegisterController;
use Modules\Auth\Http\Controllers\LoginController;
use Modules\Auth\Http\Controllers\ResetPasswordController;
use Modules\Auth\Http\Controllers\VerifyController;

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

Route::prefix('auth')->group(function () {
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/register', [RegisterController::class, 'register']);
    Route::post('/sendcode', [VerifyController::class, 'sendCode']);
    Route::post('/verifyphone/{user}', [VerifyController::class, 'verifyPhone']);
    Route::post('/resetpassword/{user}', [ResetPasswordController::class, 'reset']);
});
