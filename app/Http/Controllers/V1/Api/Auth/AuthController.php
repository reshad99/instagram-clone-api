<?php

namespace App\Http\Controllers\V1\Api\Auth;

use App\Http\Controllers\V1\Controller;
use App\Http\Requests\V1\Auth\LoginRequest;
use App\Http\Requests\V1\Auth\RegisterRequest;
use App\Http\Requests\V1\Auth\UpdateRequest;
use App\Services\V1\Auth\ApiService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $authService;

    public function __construct()
    {
        $this->authService = new ApiService();
    }

    public function login(LoginRequest $request)
    {
        return $this->authService->login($request);
    }

    public function logout(Request $request)
    {
        return $this->authService->logout();
    }

    public function register(RegisterRequest $request)
    {
        return $this->authService->register($request);
    }

    public function updateProfile(UpdateRequest $request)
    {
        return $this->authService->updateProfile($request);
    }
}
