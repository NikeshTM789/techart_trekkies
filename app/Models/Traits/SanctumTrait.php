<?php

namespace App\Models\Traits;

trait SanctumTrait
{
    public function getAuthToken(){
        $newToken = $this->createToken($this->email, ['*']);
        return $newToken->plainTextToken;
    }
}
