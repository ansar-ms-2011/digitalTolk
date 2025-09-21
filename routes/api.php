<?php

use App\Http\Controllers\TranslationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

Route::middleware('jwt.auth')->group(function () {
    Route::get('user', [AuthController::class, 'me']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::resource('translations', TranslationController::class)->only(['index', 'store', 'update', 'destroy'])->parameters(['translations' => 'translationKey']);;
    Route::get('translations-json/{lang}', [TranslationController::class, 'getJsonExport']);;
});
