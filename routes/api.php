<?php

use App\Http\Controllers\Api\AuthApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::controller(AuthApiController::class)->group(function(){
    Route::post('register','register');
    Route::post('login','login');
});