<?php

namespace App\Exceptions;

class NotFoundException extends CommonErrorException
{
    protected $message = 'resource is not found';
    protected $error = "ERR_NOT_FOUND";
    protected $code = 404;

    public function __construct($message = null)
    {
        $this->message = $message ?? $this->message;
    }

    public function getError()
    {
        return $this->error;
    }
}
