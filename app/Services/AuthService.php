<?php

namespace App\Services;

use App\Interfaces\Repositories\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AuthService
{
    protected UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(array $data): array
    {
        try {
            DB::beginTransaction();

            $user = $this->userRepository->create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'],
            ]);

            $token = $user->createToken('auth_token', ['*'], now()->addDays(7))->plainTextToken;

            event(new Registered($user));

            DB::commit();

            return [
                'user' => $user,
                'token' => $token,
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Registration failed: ' . $e->getMessage());
            throw $e;
        }
    }

    public function login(array $credentials): array
    {
        try {
            if (!Auth::attempt($credentials)) {
                throw new \Exception('Invalid credentials', 401);
            }

            $user = $this->userRepository->findByEmail($credentials['email']);

            if (!$user) {
                throw new \Exception('User not found', 404);
            }

            $user->tokens()->delete();

            $token = $user->createToken('auth_token', ['*'], now()->addDays(7))->plainTextToken;


            Log::info('User logged in', ['user_id' => $user->id, 'email' => $user->email]);

            return [
                'user' => $user,
                'token' => $token,
           
            ];
        } catch (\Exception $e) {
            Log::error('Login failed: ' . $e->getMessage());
            throw $e;
        }
    }

    public function logout(Request $request): bool
    {
        try {
            $user = $request->user();
            
            if ($user) {
                $request->user()->currentAccessToken()->delete();
                Log::info('User logged out', ['user_id' => $user->id]);
            }

            return true;
        } catch (\Exception $e) {
            Log::error('Logout failed: ' . $e->getMessage());
            return false;
        }
    }

  
}   