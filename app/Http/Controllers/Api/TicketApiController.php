<?php

namespace App\Http\Controllers\Api;

use App\Enum\TicketStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\Rule;
use App\Http\Requests\TicketReplyRequest;
use App\Models\Reply;
use Illuminate\Support\Facades\DB;

class TicketApiController extends Controller
{
    public function updateTicketStatus(Request $request, Ticket $ticket){
        $status = $request->validate(['status' => Rule::in(TicketStatusEnum::values())]);
        $ticket->update($status);
        return Response::successJson('Ticket Status updated');
    }

    public function addTicketReply(TicketReplyRequest $request, Ticket $ticket){
        DB::transaction(function () use($ticket,$request){
            $ticket->replies()->create($request->validated());
        });
        return Response::successJson('Ticket Replied');
    }
}
