<?php

use App\Enum\RoleEnum;
use App\Http\Controllers\Api\AdminApiController;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\UserApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::controller(AuthApiController::class)->group(function(){
    Route::post('register','register');
    Route::post('login','login');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::controller(UserApiController::class)->group(function(){
        Route::post('tickets', 'createTicket');
        Route::get('tickets/{ticket?}', 'getTicket');
    });
    Route::prefix('admin')->controller(AdminApiController::class)->middleware(['role:admin'])->group(function(){
        Route::post('agents', 'createAgent');
        Route::get('tickets', 'getTickets');
    });
});