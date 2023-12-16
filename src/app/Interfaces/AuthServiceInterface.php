<?php

namespace App\Interfaces;

use App\Http\Requests\LoginRequest;

interface AuthServiceInterface
{
    public function login(LoginRequest $request);
}
