<?php

namespace App\Models;

use App\Enum\TicketPriorityEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Ticket extends Model
{
    protected $fillable = [
        'title',
        'description',
        'status',
        'agent_id',
        'priority'
    ];

    protected function casts(): array
    {
        return [
            'priority' => TicketPriorityEnum::class
        ];
    }

    public static function boot()
    {
        parent::boot();
        static::creating(function ($ticket) {
            $ticket->user_id = Auth::id();
        });
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function agent(){
        return $this->belongsTo(Agent::class);
    }
    /**
     * ticket can have many replies
     * in case of ticket status can again be 'IN PROGRESS'
     * if previously not 'RESOLVED' properly
     */
    public function replies(){
        return $this->HasMany(Reply::class);
    }
}
