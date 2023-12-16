<?php

namespace App\Exceptions;

class InvalidAccessTokenException extends CommonErrorException
{
    protected $message = 'invalid access token';
    protected $error = "ERR_INVALID_ACCESS_TOKEN";
    protected $code = 401;

    public function getError()
    {
        return $this->error;
    }
}
