<?php

namespace App\Models;

use App\Enum\TicketStatusEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Reply extends Model
{
    protected $fillable = [
        'message',
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($reply) {
            $reply->agent_id = Auth::id();
        });
        static::created(function ($reply) {
            $reply->ticket->update(['status' => TicketStatusEnum::CLOSED->value]);
        });
    }

    public function ticket(){
        return $this->belongsTo(Ticket::class);
    }
}
