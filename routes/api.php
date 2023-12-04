<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('register/user', [App\Http\Controllers\Api\AuthController::class, 'registerUser']);
Route::post('login/user', [App\Http\Controllers\Api\AuthController::class, 'loginUser']);
Route::post('register/recruiter', [App\Http\Controllers\Api\AuthController::class, 'registerRecruiter']);
Route::post('login/recruiter', [App\Http\Controllers\Api\AuthController::class, 'loginRecruiter']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [App\Http\Controllers\Api\AuthController::class, 'logout']);
});
