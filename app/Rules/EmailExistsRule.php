<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;

class EmailExistsRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $email_does_not_exists_in_users = DB::table('users')->where('email',$value)->doesntExist();
        $email_does_not_exists_in_agents = DB::table('agents')->where('email',$value)->doesntExist();
        if ($email_does_not_exists_in_users && $email_does_not_exists_in_agents) {
            $fail('The :attribute does not exists');
        }
    }
}
