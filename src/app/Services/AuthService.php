<?php

namespace App\Services;

use App\Exceptions\CommonErrorException;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use App\Interfaces\AuthServiceInterface;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthService implements AuthServiceInterface
{
    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw new CommonErrorException('User not found or password is incorrect', 'ERR_INVALID_CREDENTIALS', 401);
        }

        $accessToken = $user->createToken('apiToken', ['manage-reminders'], now()->addSeconds(20))->plainTextToken;
        $refreshToken = $user->createToken('refreshToken', ['refresh_token'], now()->addDays(7))->plainTextToken;

        return [
            'user' => new UserResource($user),
            'access_token' => $accessToken,
            'refresh_token' => $refreshToken
        ];
    }
}
