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

$admin = RoleEnum::ADMIN->value;
$agent = RoleEnum::AGENT->value;
$user = RoleEnum::USER->value;

Route::middleware('auth:sanctum')->group(function () use($admin,$agent,$user){ 
    Route::controller(TicketApiController::class)->group(function()use($admin,$agent,$user){
        Route::patch('tickets/update_status/{ticket}', 'updateTicketStatus')->middleware(['role:'.$admin.'|'.$agent]);
        Route::post('tickets/{ticket}/reply', 'addTicketReply')->middleware(['role:'.$agent]);
        Route::get('tickets/{ticket?}', 'getTickets')->middleware(['role:'.$user.'|'.$agent]);# route to get ticket list for agent/user
        Route::get('admin/tickets', 'getTickets')->middleware(['role:'.$admin]);# route to get ticket list for admin 
    });

    Route::middleware(['role:'.$user])->controller(UserApiController::class)->group(function(){
        Route::post('tickets', 'createTicket');
    });
    
    Route::prefix('admin')->controller(AdminApiController::class)->middleware(['role:'.$admin])->group(function(){
        Route::post('agents', 'createAgent');
        Route::get('roles', 'getRoles');
        Route::patch('assign-agent-to-ticket/{ticket}', 'assignTicket');# assign ticket to an agent route
        Route::patch('update-ticket-priority/{ticket}', 'updateTicketPriority');
    });
});