<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Ticket extends Model
{
    protected $fillable = [
        'title',
        'description'
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($ticket) {
            $ticket->user_id = Auth::id();
        });
    }
}
