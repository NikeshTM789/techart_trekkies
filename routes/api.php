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
        Route::post('tickets/{ticket}/reply', 'addTicketReply')->middleware(['role:agent']);
        Route::get('tickets/{ticket?}', 'getTickets')->middleware(['role:user']);
        Route::get('admin/tickets', 'getTickets')->middleware(['role:admin']);

    });

    Route::controller(UserApiController::class)->group(function(){
        Route::post('tickets', 'createTicket');
    });
    Route::prefix('admin')->controller(AdminApiController::class)->middleware(['role:admin'])->group(function(){
        Route::post('agents', 'createAgent');
    });
});