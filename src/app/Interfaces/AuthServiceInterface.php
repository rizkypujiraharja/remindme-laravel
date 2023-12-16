<?php

namespace App\Interfaces;

use App\Http\Requests\LoginRequest;
use App\Models\User;

interface AuthServiceInterface
{
    public function login(LoginRequest $request);
    public function refreshToken(User $user);
}
