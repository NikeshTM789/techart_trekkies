<?php

namespace App\Http\Resources;

use App\Enum\RoleEnum;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class TicketResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            'user_id' => $this->when(Auth::user()->hasRole(RoleEnum::ADMIN->value), $this->user_id),
            "title" => $this->title,
            "description" => $this->description,
            "status" => $this->status,
            "priority" => $this->priority->name
        ];
    }
}
