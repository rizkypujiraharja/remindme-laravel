<?php

namespace Tests\Unit;

use App\Exceptions\BadRequestException;
use App\Exceptions\CommonErrorException;
use App\Exceptions\ForbiddenAccessException;
use App\Exceptions\InvalidAccessTokenException;
use App\Exceptions\InvalidCredException;
use App\Exceptions\InvalidRefreshTokenException;
use App\Exceptions\NotFoundException;
use PHPUnit\Framework\TestCase;

class CommonErrorExceptionTest extends TestCase
{
    public function testCommonErrorException(): void
    {
        $exception = new CommonErrorException();
        $this->assertEquals('Internal Server Error', $exception->getMessage());
        $this->assertEquals('ERR_INTERNAL_ERROR', $exception->getError());
        $this->assertEquals(500, $exception->getCode());
    }

    public function testCommonErrorExceptionWithCustomError(): void
    {
        $exception = new CommonErrorException('Something went wrong', 'ERR_CUSTOM_ERROR');
        $this->assertEquals('Something went wrong', $exception->getMessage());
        $this->assertEquals('ERR_CUSTOM_ERROR', $exception->getError());
        $this->assertEquals(500, $exception->getCode());
    }

    public function testBadRequestException(): void
    {
        $exception = new BadRequestException();
        $this->assertEquals('bad request', $exception->getMessage());
        $this->assertEquals('ERR_BAD_REQUEST', $exception->getError());
        $this->assertEquals(400, $exception->getCode());
    }

    public function testBadRequestExceptionWithCustomError(): void
    {
        $exception = new BadRequestException('invalid value of `type`');
        $this->assertEquals('invalid value of `type`', $exception->getMessage());
        $this->assertEquals('ERR_BAD_REQUEST', $exception->getError());
        $this->assertEquals(400, $exception->getCode());
    }

    public function testForbiddenAccessException(): void
    {
        $exception = new ForbiddenAccessException();
        $this->assertEquals('user doesn\'t have enough authorization', $exception->getMessage());
        $this->assertEquals('ERR_FORBIDDEN_ACCESS', $exception->getError());
        $this->assertEquals(403, $exception->getCode());
    }

    public function testInvalidAccessTokenException(): void
    {
        $exception = new InvalidAccessTokenException();
        $this->assertEquals('invalid access token', $exception->getMessage());
        $this->assertEquals('ERR_INVALID_ACCESS_TOKEN', $exception->getError());
        $this->assertEquals(401, $exception->getCode());
    }

    public function testInvalidCredentialsException(): void
    {
        $exception = new InvalidCredException();
        $this->assertEquals('incorrect username or password', $exception->getMessage());
        $this->assertEquals('ERR_INVALID_CREDS', $exception->getError());
        $this->assertEquals(401, $exception->getCode());
    }

    public function testInvalidRefreshTokenException(): void
    {
        $exception = new InvalidRefreshTokenException();
        $this->assertEquals('invalid refresh token', $exception->getMessage());
        $this->assertEquals('ERR_INVALID_REFRESH_TOKEN', $exception->getError());
        $this->assertEquals(401, $exception->getCode());
    }

    public function testNotFoundException(): void
    {
        $exception = new NotFoundException();
        $this->assertEquals('resource is not found', $exception->getMessage());
        $this->assertEquals('ERR_NOT_FOUND', $exception->getError());
        $this->assertEquals(404, $exception->getCode());
    }

    public function testNotFoundExceptionWithCustomError(): void
    {
        $exception = new NotFoundException('user not found');
        $this->assertEquals('user not found', $exception->getMessage());
        $this->assertEquals('ERR_NOT_FOUND', $exception->getError());
        $this->assertEquals(404, $exception->getCode());
    }
}
