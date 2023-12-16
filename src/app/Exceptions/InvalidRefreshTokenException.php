<?php

namespace App\Exceptions;

class InvalidRefreshTokenException extends CommonErrorException
{
    protected $message = 'invalid refresh token';
    protected $error = "ERR_INVALID_REFRESH_TOKEN";
    protected $code = 401;

    public function getError()
    {
        return $this->error;
    }
}
