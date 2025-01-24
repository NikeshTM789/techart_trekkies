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

    public function getTicket(Ticket $ticket = null){
        if ($ticket) {
            if ($ticket->user->isNot(Auth::user())) {
                return Response::errorJson('Not Found');
            }
            $ticket = new TicketResource($ticket);
            return Response::successJson('User Ticket', $ticket);
        }
        $tickets = Ticket::whereBelongsTo(Auth::user())->paginate();
        
        $pagination_data = $tickets->toArray();
		['links' => $links] = $pagination_data;
        $tickets = TicketResource::collection($tickets);
        return Response::successJson('User Ticket List', compact('tickets','links'));
    }
}
