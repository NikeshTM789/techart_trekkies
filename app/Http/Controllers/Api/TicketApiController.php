<?php

namespace App\Http\Controllers\Api;

use App\Enum\RoleEnum;
use App\Enum\TicketStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\Rule;
use App\Http\Requests\TicketReplyRequest;
use App\Http\Resources\TicketResource;
use App\Models\Reply;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TicketApiController extends Controller
{
    public function getTickets(Ticket $ticket = null)
    {
        if ($ticket) {
            if ($ticket->user->isNot(Auth::user())) {
                return Response::errorJson('Not Found');
            }
            $ticket = new TicketResource($ticket);
            return Response::successJson('User Ticket', $ticket);
        }else{
            $user = Auth::user();
            if ($user->hasRole(RoleEnum::ADMIN->value)) {
                $tickets = Ticket::paginate();
            } else {
                $tickets = Ticket::whereBelongsTo(Auth::user())->paginate();
            }
            $pagination_data = $tickets->toArray();
            ['links' => $links] = $pagination_data;
            $tickets = TicketResource::collection($tickets);
            return Response::successJson('User Ticket List', compact('tickets', 'links'));
        }
    }
    public function updateTicketStatus(Request $request, Ticket $ticket)
    {
        $status = $request->validate(['status' => Rule::in(TicketStatusEnum::values())]);
        $ticket->update($status);
        return Response::successJson('Ticket Status updated');
    }

    public function addTicketReply(TicketReplyRequest $request, Ticket $ticket)
    {
        DB::transaction(function () use ($ticket, $request) {
            $ticket->replies()->create($request->validated());
        });
        return Response::successJson('Ticket Replied');
    }
}
