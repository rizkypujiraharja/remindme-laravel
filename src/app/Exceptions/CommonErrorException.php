<?php

namespace App\Exceptions;

use Exception;

class CommonErrorException extends Exception
{
    protected $message = 'Internal Server Error';
    protected $error = "ERR_INTERNAL_ERROR";
    protected $code = 500;

    public function __construct($message = null, $error = null, $code = null)
    {
        $this->message = $message ?? $this->message;
        $this->error = $error ?? $this->error;
        $this->code = $code ?? $this->code;
    }

    public function getError()
    {
        return $this->error;
    }
}
