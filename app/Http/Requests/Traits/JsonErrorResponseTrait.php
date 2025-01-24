<?php

namespace App\Http\Requests\Traits;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Response;

trait JsonErrorResponseTrait
{
    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();

        // Return your custom JSON response
        throw new HttpResponseException(
            Response::errorJson('error occurred', $errors)
            /* response()->json([
                'message' => 'error occurred',
                'errors' => $errors
            ], 422) */
        );
    }
}
