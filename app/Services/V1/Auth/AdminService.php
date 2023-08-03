<?php

namespace App\Services\V1\Auth;

use App\Services\V1\CommonService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AdminService extends CommonService
{
    public function __construct()
    {
        $this->rules = [
            'email' => 'required|email|max:255',
            'password' => 'required|max:255',
        ];
        $this->fields = ['email', 'password'];
    }

    public function loginPage()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        try {
            $this->ajaxValidate($request, $this->rules);
            $rememberMe = $request->remember_me ? true : false;
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $rememberMe)) {
                return $this->succesResponse('Giriş uğurlu oldu');
            } else {
                throw new Exception('Email və ya şifrə səhvdir');
            }
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    public function logout()
    {
        Auth::logout();
        Log::info("logout oldu");
        return redirect('/gopanel/login');
    }
}
