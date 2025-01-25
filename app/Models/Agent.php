<?php

namespace App\Models;

use App\Models\Traits\SanctumTrait;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Agent extends Authenticatable
{
    use HasApiTokens, HasRoles, SanctumTrait;

    protected $guard_name = 'web';
    
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
