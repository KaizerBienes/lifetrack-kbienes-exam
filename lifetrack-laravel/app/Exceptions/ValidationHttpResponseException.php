<?php

namespace App\Exceptions;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class ValidationHttpResponseException extends HttpResponseException {
    protected $code;
    protected $message;

    public function __construct(string $message, int $code, Response $errorResponse)
    {
        $this->code = $code;
        $this->message = $message;

        parent::__construct($errorResponse);
    }
}