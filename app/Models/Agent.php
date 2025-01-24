<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class Agent extends Model
{
    use HasApiTokens, HasRoles;

    protected $guard_name = 'web';
    
    protected $fillable = [
        'name',
        'email',
        'password',
    ];
}
