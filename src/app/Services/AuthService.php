<?php

namespace App\Services;

use App\Exceptions\InvalidCredException;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use App\Interfaces\AuthServiceInterface;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthService implements AuthServiceInterface
{
    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw new InvalidCredException();
        }

        $accessToken = $user->createToken('apiToken', ['manage-reminders'], now()->addSeconds(20))->plainTextToken;
        $refreshToken = $user->createToken('refreshToken', ['refresh_token'], now()->addDays(7))->plainTextToken;

        return [
            'user' => new UserResource($user),
            'access_token' => $accessToken,
            'refresh_token' => $refreshToken
        ];
    }

    public function refreshToken(User $user)
    {
        $accessToken = $user->createToken('apiToken', ['manage-reminders'], now()->addSeconds(20))->plainTextToken;

        return [
            'access_token' => $accessToken,
        ];
    }
}
