<?php

use Illuminate\Support\Facades\Route;

Route::get('/cities', function () {
    return response()->file(public_path('assets/states.json'));
});
Route::get('/cources', function () {
    return view('cources.couces');
})->name('cources');

Route::get('/terms', function () {
    return view('terms');
})->name('terms');

Route::get('/privacy-policy', function () {
    return view('privacy-policy');
})->name('privacy-policy');


