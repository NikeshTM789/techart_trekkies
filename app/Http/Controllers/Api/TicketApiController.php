<?php

namespace App\Http\Controllers\Api;

use App\Enum\RoleEnum;
use App\Enum\TicketPriorityEnum;
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
    public function getTickets(Request $request, Ticket $ticket = null)
    {
        $user = Auth::user() ?? Auth::guard('agent')->user();
        $isAdmin = $user->hasRole(RoleEnum::ADMIN->value);
        $isAgent = $user->hasRole(RoleEnum::AGENT->value);
        $isUser = $user->hasRole(RoleEnum::USER->value);
        if ($ticket) {
            $ticket = new TicketResource($ticket);
            if ($isAdmin) {
                $message = 'Admin Ticket';
            }elseif ($isAgent) {
                if (empty($ticket->agent) || $ticket->agent->isNot($user)) {
                    return Response::errorJson('Not Found');
                }
                $message = 'Agent Ticket';
            }elseif ($isUser) {
                if ($ticket->user->isNot($user)) {
                    return Response::errorJson('Not Found');
                }
                $message = 'User Ticket';
            }
            return Response::successJson($message, $ticket);

        }else{
            $tickets = Ticket::query();
            if ($isAdmin) {
                $message = 'All Ticket List';
            } elseif($isAgent || $isUser) {
                $message = $isAgent ? 'Agent Ticket List' : 'User Ticket List';
                $tickets = $tickets->whereBelongsTo($user);
            }
            /**
             * I gave every role can sort their ticket list 
             * based on its priority[0 => 'low', 1 => 'medium' ,2 => 'high']
             */
            $priority_value = TicketPriorityEnum::getKeyByName($request->query('priority'));
            $tickets = $tickets->when(is_int($priority_value), fn($qry) => $qry->where('priority',$priority_value))->paginate();

            $pagination_data = $tickets->toArray();
            ['links' => $links] = $pagination_data;
            $tickets = TicketResource::collection($tickets);
            return Response::successJson($message, compact('tickets', 'links'));
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
