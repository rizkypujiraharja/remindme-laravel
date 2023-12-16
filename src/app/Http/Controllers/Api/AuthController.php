<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Interfaces\AuthServiceInterface;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use ApiResponses;

    protected $authService;

    public function __construct(AuthServiceInterface $authService)
    {
        $this->authService = $authService;
    }

    public function login(LoginRequest $request)
    {
        $loggedInUser = $this->authService->login($request);
        return $this->successApiResponse($loggedInUser);
    }

    public function refreshToken(Request $request)
    {
        $user = $request->user();
        $refreshToken = $this->authService->refreshToken($user);
        return $this->successApiResponse($refreshToken);
    }
}
