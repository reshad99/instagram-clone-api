<?php

namespace App\Http\Controllers\v1\Admin;

use App\Http\Controllers\v1\Controller;
use App\Services\Auth\AdminService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $authService;
    public function __construct()
    {
        $this->authService = new AdminService;
    }

    public function loginPage()
    {
        return $this->authService->loginPage();
    }

    public function login(Request $request)
    {
        return $this->authService->login($request);
    }

    public function logout()
    {
        return $this->authService->logout();
    }
}
