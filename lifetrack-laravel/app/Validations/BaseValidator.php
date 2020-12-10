<?php

namespace App\Validations;

use Illuminate\Http\Response;

class BaseValidator {
    public static function constructResponse(array $errors, int $code, string $message)
    {
        $response = new Response();
        $response->setContent([
            'code' => $code,
            'message' => $message,
            'errors' => $errors
        ]);

        return $response;
    }
}