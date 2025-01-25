<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserTicketRequest;
use App\Http\Resources\TicketResource;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class UserApiController extends Controller
{
    public function createTicket(CreateUserTicketRequest $request){
        Ticket::create($request->validated());
        return Response::successJson('Ticket Added');
    }
}
