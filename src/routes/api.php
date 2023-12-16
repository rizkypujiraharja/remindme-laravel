<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ReminderController;
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

Route::group(['middleware' => 'api'], function ($router) {
    Route::post('/session', [AuthController::class, 'login'])->name('login');
    Route::put('/session', [AuthController::class, 'refreshToken'])
        ->middleware(['auth:sanctum', 'ability:refresh_token'])
        ->name('refresh_token');

    Route::group(['middleware' => ['auth:sanctum', 'ability:manage-reminders']], function ($router) {
        Route::get('/reminders', [ReminderController::class, 'index'])->name('reminders.index');
    });
});
