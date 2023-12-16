<?php

namespace App\Exceptions;

class ForbiddenAccessException extends CommonErrorException
{
    protected $message = 'user doesn\'t have enough authorization';
    protected $error = "ERR_FORBIDDEN_ACCESS";
    protected $code = 403;

    public function getError()
    {
        return $this->error;
    }
}
