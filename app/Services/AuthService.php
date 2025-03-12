<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthService
{
    public function register($data)
    {
        try {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'type' => $data['type'],
            ]);

            return [
                'success' => true,
                'data' => [
                    'user' => $user,
                ],
            ];
        } catch (\Exception $e) {
            Log::error('User registration failed: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'User registration failed.',
            ];
        }
    }

    public function login($credentials)
    {
        if (!Auth::attempt($credentials)) {
            return [
                'success' => false,
                'message' => 'Invalid credentials.',
            ];
        }

        return [
            'success' => true,
            'data' => [
                'user' => Auth::user(),
            ],
        ];
    }

    public function logout($request)
    {
        Auth::logout();
        return [
            'success' => true,
        ];
    }
}
