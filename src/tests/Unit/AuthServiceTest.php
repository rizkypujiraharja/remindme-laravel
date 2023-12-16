<?php

namespace Tests\Unit;

use App\Exceptions\InvalidCredException;
use App\Http\Requests\LoginRequest;
use App\Interfaces\AuthServiceInterface;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = app()->make(AuthServiceInterface::class);
    }

    public function testLoginSuccess()
    {
        $user = $this->createUser();

        $request = $this->createLoginRequest($user->email, 'password');

        $result = $this->service->login($request);

        $this->assertArrayHasKey('user', $result);
        $this->assertArrayHasKey('access_token', $result);
        $this->assertArrayHasKey('refresh_token', $result);
    }

    public function testLoginFailure()
    {
        $user = $this->createUser();

        $request = $this->createLoginRequest($user->email, 'wrongpassword');

        $this->expectException(InvalidCredException::class);

        $this->service->login($request);
    }

    public function testRefreshToken()
    {
        $user = User::factory()->create();

        $result = $this->service->refreshToken($user);

        $this->assertArrayHasKey('access_token', $result);
    }

    protected function createUser()
    {
        return User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);
    }

    protected function createLoginRequest($email, $password)
    {
        $request = new LoginRequest();
        $request->merge([
            'email' => $email,
            'password' => $password,
        ]);

        return $request;
    }
}
