<?php

namespace App\Http\Controllers\Api;

use App\Enum\RoleEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\AgentCreateRequest;
use App\Http\Resources\TicketResource;
use App\Models\Agent;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class AdminApiController extends Controller
{
    public function createAgent(AgentCreateRequest $request){
        DB::transaction(function () use($request){
            $agent = Agent::create($request->validated());
            $agent->assignRole(RoleEnum::AGENT->value);
        });
        return Response::successJson('Agent Added');
    }

    public function getTickets(){
        $tickets = Ticket::paginate();
        
        $pagination_data = $tickets->toArray();
		['links' => $links] = $pagination_data;
        $tickets = TicketResource::collection($tickets);
        return Response::successJson('User Ticket List', compact('tickets','links'));
    }
}
