<?php

use App\Http\Controllers\Api\ProfilingController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('profiling')->name('profiling.')->group(function () {
        Route::get('questions', [ProfilingController::class, 'list'])->name('questions');
    });

    Route::prefix('user')->name('user.')->group(function () {
        // Route::get('/', function (Request $request) {
        //     return $request->user();
        // });

        Route::patch('/', [UserController::class, 'update'])->name('update');
        Route::get('wallet', [UserController::class, 'wallet'])->name('wallet');
    });
});
