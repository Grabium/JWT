<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginJWTController;

/*
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
*/
//https://20c8f919-e5db-44a4-91f5-7069d08cf037-00-3asn5jy9t1ncf.worf.replit.dev/api/user

Route::resource('/user', UserController::class);

Route::post('/login', [LoginJWTController::class, 'login'])->name('login');