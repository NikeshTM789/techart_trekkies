<?php

use App\Enum\RoleEnum;
use App\Http\Controllers\Api\AdminApiController;
use App\Http\Controllers\Api\AgentApiController;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\TicketApiController;
use App\Http\Controllers\Api\UserApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::controller(AuthApiController::class)->group(function(){
    Route::post('register','register');
    Route::post('login','login');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::controller(TicketApiController::class)->group(function(){
        Route::patch('tickets/update_status/{ticket}', 'updateTicketStatus')->middleware(['role:admin|agent']);
    });

    Route::controller(UserApiController::class)->group(function(){
        Route::post('tickets', 'createTicket');
        Route::get('tickets/{ticket?}', 'getTicket');
    });
    Route::prefix('admin')->controller(AdminApiController::class)->middleware(['role:admin'])->group(function(){
        Route::post('agents', 'createAgent');
        Route::get('tickets', 'getTickets');
    });
    Route::controller(AgentApiController::class)->middleware(['role:agent'])->group(function(){
        Route::post('tickets/{ticket}/reply', 'addTicketReply');
    });
});