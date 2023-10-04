<?php

namespace App\Services\V1\Auth;

use App\Http\Requests\V1\Auth\LoginRequest;
use App\Http\Requests\V1\Auth\RegisterRequest;
use App\Http\Requests\V1\Auth\UpdateRequest;
use App\Http\Resources\V1\User\CustomerResource;
use App\Models\Customer;
use App\Services\V1\CommonService;
use Exception;
use Tymon\JWTAuth\Facades\JWTAuth;

class ApiService extends CommonService
{
    public function __construct()
    {
        parent::__construct(null, [], 'auth');
    }

    public function login(LoginRequest $request)
    {
        try {
            $credentials = [
                $this->loginType($request->login) => $request->login,
                'password' => $request->password
            ];

            if (!$token = auth()->attempt($credentials)) {
                throw new Exception('Email və ya şifrə səhvdir');
            } else {
                return $this->respondWithToken($token, auth()->user());
            }
        } catch (\Exception $e) {
            $this->errorLogging('login: ' . $e->getMessage());
            throw $e;
        }
    }

    public function register(RegisterRequest $request)
    {
        try {
            $customer = Customer::create($request->all());
            $token = JWTAuth::fromUser($customer);
            return $this->respondWithToken($token, $customer);
        } catch (\Exception $e) {
            $this->errorLogging('register: ' . $e->getMessage());
            throw $e;
        }
    }

    public function logout()
    {
        try {
            if (auth()->check())
                auth()->logout();

            $this->infoLogging('logout check: ' . auth()->check());

            return $this->successResponse('Hesabdan çıxıldı');
        } catch (\Exception $e) {
            $this->errorLogging('logout: ' . $e->getMessage());
            throw $e;
        }
    }

    public function updateProfile(UpdateRequest $request)
    {
        try {
            auth()->user()->update($request->all());
            return $this->dataResponse('Məlumatlar yeniləndi', new CustomerResource(auth()->user()));
        } catch (\Exception $e) {
            $this->errorLogging('updateProfile: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token, Customer $customer)
    {
        return response()->json([
            'success' => true,
            'user' => new CustomerResource($customer),
            'access_token' => $token,
            'token_type' => 'bearer',
        ]);
    }

    /**
     * Check whether the login type is email or username.
     *
     * @param  string  $login
     * @return string
     */
    private function loginType($login)
    {
        return filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
    }
}
