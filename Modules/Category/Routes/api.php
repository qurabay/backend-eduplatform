<?php

use Illuminate\Support\Facades\Route;
use Modules\Category\Http\Controllers\SectionController;
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

//Route::group(['prefix' => 'v1','middleware'=> ['auth:sanctum']], function () {

Route::group(['prefix' => 'v1'], function () {

    Route::group(['prefix' => 'section'], function () {
        Route::get('/', [SectionController::class, 'index']);
        Route::get('/{section}', [SectionController::class, 'show']);
        Route::post('/', [SectionController::class, 'store'])->middleware(['auth:sanctum']);
        Route::post('update/{section}', [SectionController::class, 'update'])->middleware(['auth:sanctum']);

    });
});
