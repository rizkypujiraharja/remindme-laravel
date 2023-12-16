<?php

namespace App\Exceptions;

class BadRequestException extends CommonErrorException
{
    protected $message = 'bad Request';
    protected $error = "ERR_BAD_REQUEST";
    protected $code = 400;

    public function __construct($message = null)
    {
        $this->message = $message ?? $this->message;
    }

    public function getError()
    {
        return $this->error;
    }
}
