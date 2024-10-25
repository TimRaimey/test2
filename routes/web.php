<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home')->middleware('auth');
Route::view('/history', 'history')->name('history')->middleware('auth');
Route::view('/auth', 'auth')->name('auth')->middleware('guest');


Route::post('/api/login', [App\Http\Controllers\AuthController::class, 'login']);
Route::get('/api/user-data', [App\Http\Controllers\UserDataController::class, 'getUserData'])->middleware('auth');
Route::get('/api/operations', [App\Http\Controllers\UserDataController::class, 'getOperations'])->middleware('auth');


