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

Route::middleware('auth:sanctum')->group(function () {
    Route::get('categories', [App\Http\Controllers\Api\CategoryController::class, 'index']);
    Route::get('ktp/data', [App\Http\Controllers\Api\KtpController::class, 'index']);
    Route::post('ktp/verification', [App\Http\Controllers\Api\KtpController::class, 'verification']);
    Route::get('ktp/ocr-results', [App\Http\Controllers\Api\KtpController::class, 'ocrResults']);
    Route::post('biodata' , [App\Http\Controllers\Api\BiodataController::class, 'store']);
    Route::post('logout', [App\Http\Controllers\Api\AuthController::class, 'logout']);

    Route::middleware('role:user')->group(function () {
        Route::get('home/user', [App\Http\Controllers\Api\HomeController::class, 'index']);
        Route::get('works/user' , [App\Http\Controllers\Api\WorkController::class, 'index']);
        Route::get('works/user/{id}' , [App\Http\Controllers\Api\WorkController::class, 'show']);
        Route::get('get-job/{id}' , [App\Http\Controllers\Api\OfferController::class, 'getJob']);
        Route::post('place-an-offer', [App\Http\Controllers\Api\OfferController::class, 'placeAnOffer']);
        Route::get('offers/user', [App\Http\Controllers\Api\OfferController::class, 'offersUser']);
    });

    Route::middleware('role:recruiter')->group(function () {
        Route::get('home/recruiter', [App\Http\Controllers\Api\HomeController::class, 'recruiter']);
        Route::post('works' , [App\Http\Controllers\Api\WorkController::class, 'store']);
        Route::get('works/recruiter' , [App\Http\Controllers\Api\WorkController::class, 'posts']);
        Route::get('works/recruiter/{id}' , [App\Http\Controllers\Api\WorkController::class, 'detail']);
        Route::get('offers/recruiter', [App\Http\Controllers\Api\OfferController::class, 'offersRecruiter']);
        Route::get('payments/{id}', [App\Http\Controllers\Api\PaymentController::class, 'index']);
        Route::post('payments', [App\Http\Controllers\Api\PaymentController::class, 'store']);
        Route::put('offers/finished/{id}', [App\Http\Controllers\Api\OfferController::class, 'finished']);
    });
});
