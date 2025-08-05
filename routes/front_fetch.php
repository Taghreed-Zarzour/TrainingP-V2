<?php

use Illuminate\Support\Facades\Route;

Route::get('/cities', function () {
    return response()->file(public_path('assets/states.json'));
});
Route::get('/cources', function () {
    return view('cources.couces');
})->name('cources');

