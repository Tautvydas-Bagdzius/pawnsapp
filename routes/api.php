<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\EnsureProfileUpdateOnceADay;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ProfilingController;
use App\Http\Controllers\Api\TransactionController;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('profiling')->name('profiling.')->group(function () {
        Route::get('questions', [ProfilingController::class, 'list'])->name('questions');
    });

    Route::prefix('user')->name('user.')->group(function () {
        Route::patch('/', [UserController::class, 'update'])->name('update')
            ->middleware(EnsureProfileUpdateOnceADay::class);
        Route::get('wallet', [UserController::class, 'wallet'])->name('wallet');


        Route::prefix('transactions')->name('transactions.')->group(function () {
            Route::get('/', [TransactionController::class, 'list'])->name('list');
            Route::post('/', [TransactionController::class, 'claim'])->name('claim');
        });
    });
});
