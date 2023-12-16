<?php

namespace Tests\Unit;

use App\Exceptions\BadRequestException;
use App\Exceptions\CommonErrorException;
use App\Exceptions\ForbiddenAccessException;
use App\Exceptions\InvalidAccessTokenException;
use PHPUnit\Framework\TestCase;

class CommonErrorExceptionTest extends TestCase
{
    public function test_common_error_exception(): void
    {
        $exception = new CommonErrorException();
        $this->assertEquals('Internal Server Error', $exception->getMessage());
        $this->assertEquals('ERR_INTERNAL_ERROR', $exception->getError());
        $this->assertEquals(500, $exception->getCode());
    }

    public function test_common_error_exception_with_custom_error(): void
    {
        $exception = new CommonErrorException('Something went wrong', 'ERR_CUSTOM_ERROR');
        $this->assertEquals('Something went wrong', $exception->getMessage());
        $this->assertEquals('ERR_CUSTOM_ERROR', $exception->getError());
        $this->assertEquals(500, $exception->getCode());
    }

    public function test_bad_request_exception(): void
    {
        $exception = new BadRequestException();
        $this->assertEquals('bad request', $exception->getMessage());
        $this->assertEquals('ERR_BAD_REQUEST', $exception->getError());
        $this->assertEquals(400, $exception->getCode());
    }

    public function test_bad_request_exception_with_custom_error(): void
    {
        $exception = new BadRequestException('invalid value of `type`');
        $this->assertEquals('invalid value of `type`', $exception->getMessage());
        $this->assertEquals('ERR_BAD_REQUEST', $exception->getError());
        $this->assertEquals(400, $exception->getCode());
    }

    public function test_forbidden_access_exception(): void
    {
        $exception = new ForbiddenAccessException();
        $this->assertEquals('user doesn\'t have enough authorization', $exception->getMessage());
        $this->assertEquals('ERR_FORBIDDEN_ACCESS', $exception->getError());
        $this->assertEquals(403, $exception->getCode());
    }

    public function test_invalid_access_token_exception(): void
    {
        $exception = new InvalidAccessTokenException();
        $this->assertEquals('invalid access token', $exception->getMessage());
        $this->assertEquals('ERR_INVALID_ACCESS_TOKEN', $exception->getError());
        $this->assertEquals(401, $exception->getCode());
    }
}
