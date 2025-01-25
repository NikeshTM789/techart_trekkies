<?php

namespace App\Http\Controllers\Api;

use App\Enum\TicketStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\Rule;

class TicketApiController extends Controller
{
    public function updateTicketStatus(Request $request, Ticket $ticket){
        $status = $request->validate(['status' => Rule::in(TicketStatusEnum::values())]);
        $ticket->update($status);
        return Response::successJson('Ticket Status updated');
    }
}
