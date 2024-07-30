<?php

use App\Http\Controllers\Api\ProfilingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('profiling')->group(function () {
        Route::get('questions', [ProfilingController::class, 'list']);
    });

    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});
