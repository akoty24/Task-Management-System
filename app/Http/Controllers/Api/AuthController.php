<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use ApiResponseTrait;

    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterRequest $request)
    {
        try {
            $result = $this->authService->register($request->validated());

            $responseData = array_merge(
                (new UserResource($result['user']))->resolve(),
                [
                    'token' => $result['token'],
                ]
            );

            return $this->created(
                $responseData,
                'User registered successfully.'
            );
        } catch (\Exception $e) {
            return $this->error(
                'Registration failed',
                500,
                ['error' => $e->getMessage()]
            );
        }
    }

    public function login(LoginRequest $request)
    {
        try {
            $result = $this->authService->login($request->validated());

            $responseData = array_merge(
                (new UserResource($result['user']))->resolve(),
                [
                    'token' => $result['token'],
                   
                ]
            );

            return $this->success(
                $responseData,
                'Login successful'
            );
        } catch (\Exception $e) {
            $code = (int) $e->getCode();
            $statusCode = ($code >= 100 && $code <= 599) ? $code : 401;

            return $this->error(
                $e->getMessage() ?: 'Invalid credentials',
                $statusCode,
                ['error' => $e->getMessage()]
            );
        }
    }

    public function logout(Request $request)
    {
        try {
            $this->authService->logout($request);

            return $this->success(
                null,
                'Logout successful'
            );
        } catch (\Exception $e) {
            return $this->error(
                'Logout failed',
                500
            );
        }
    }

  
}