<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\AuthService;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login()
    {
        return view('public.auth.login');
    }

    public function loginProcess(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $result = $this->authService->login($credentials);

        if (!$result['success']) {
            return back()->with('error', $result['message']);
        }

        return match (Auth::user()->type) {
            'admin' => redirect()->route('admin.dashboard'),
            'pilot' => redirect()->route('pilot.dashboard'),
            'startup' => redirect()->route('startup.dashboard'),
            default => redirect()->route('login')->with('error', 'Access denied. Your account type is not authorized.'),

        };
    }

    public function register()
    {
        return view('public.auth.register');
    }

    public function registerProcess(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $validatedData['type'] = 'startup';

        $result = $this->authService->register($validatedData);

        if (!$result['success']) {
            return back()->with('error', $result['message']);
        }

        Auth::login($result['data']['user']);
        return redirect()->route('startup.dashboard');
    }

    public function logout(Request $request)
    {
        $this->authService->logout($request);
        return redirect()->route('login');
    }
}
