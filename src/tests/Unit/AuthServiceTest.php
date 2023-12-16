<?php

namespace Tests\Unit;

use App\Exceptions\CommonErrorException;
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

    public function testLoginSuccess()
    {
        User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        $request = new LoginRequest();
        $request->merge([
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $service = app()->make(AuthServiceInterface::class);
        $result = $service->login($request);

        $this->assertArrayHasKey('user', $result);
        $this->assertArrayHasKey('access_token', $result);
        $this->assertArrayHasKey('refresh_token', $result);
    }

    public function testLoginFailure()
    {
        User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        $request = new LoginRequest();
        $request->merge([
            'email' => 'test@example.com',
            'password' => 'wrongpassword',
        ]);

        $this->expectException(InvalidCredException::class);

        $service = app()->make(AuthServiceInterface::class);
        $service->login($request);
    }
}
