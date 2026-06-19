<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing');
});

Route::redirect('/home', '/');

Route::get('/map', function () {
    return view('map');
});

Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});
