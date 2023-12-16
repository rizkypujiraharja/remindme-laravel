<?php

namespace App\Exceptions;

class InvalidCredException extends CommonErrorException
{
    protected $message = 'incorrect username or password';
    protected $error = "ERR_INVALID_CREDS";
    protected $code = 401;

    public function getError()
    {
        return $this->error;
    }
}
