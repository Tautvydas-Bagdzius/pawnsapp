<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return ['Laravel' => app()->version()];
});


/**
 * For demonstration purposes
 */
Route::get('csrf', function () {
    return ['CSRF' => csrf_token(), 'user_name' => Auth::user()?->name];
});


require __DIR__.'/auth.php';
