<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return ['Laravel' => app()->version()];
});

/**
 * For demonstration purposes
 */
Route::get('csrf', function () {
    return ['CSRF' => csrf_token()];
});

Route::post('/tokens/create', function (Request $request) {
    $userAgent = $request->server('HTTP_USER_AGENT');
    $token = $request->user()->createToken($userAgent);

    return ['token' => $token->plainTextToken];
});

require __DIR__ . '/auth.php';
