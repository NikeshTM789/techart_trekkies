<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Ticket extends Model
{
    protected $fillable = [
        'title',
        'description',
        'status',
        'agent_id'
    ];

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

    public function replies(){
        return $this->HasMany(Reply::class);
    }
}
