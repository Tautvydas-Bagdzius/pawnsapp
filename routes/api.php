<?php

use App\Http\Controllers\Api\ProfilingController;
use App\Http\Controllers\Api\UserController;
use App\Http\Middleware\EnsureProfileUpdateOnceADay;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('profiling')->name('profiling.')->group(function () {
        Route::get('questions', [ProfilingController::class, 'list'])->name('questions');
    });

    Route::prefix('user')->name('user.')->group(function () {
        Route::patch('/', [UserController::class, 'update'])->name('update')
            ->middleware(EnsureProfileUpdateOnceADay::class);
        Route::get('wallet', [UserController::class, 'wallet'])->name('wallet');
        Route::get('transactions', [UserController::class, 'transactions'])->name('transactions');
    });
});
