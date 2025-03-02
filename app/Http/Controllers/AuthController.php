<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
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
        if (Auth::attempt($credentials)) {
            switch (Auth::user()->type) {
                case 'admin':
                    return redirect()->route('admin.dashboard');
                case 'pilot':
                    return redirect()->route('pilot.dashboard');
                case 'startup':
                    return redirect()->route('startup.dashboard');
                default:
                    Auth::logout();
                    return redirect()->route('login')->withErrors(['error' => 'Unauthorized user type.']);
            }
        }

        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    public function register()
    {
        return view('public.auth.register');
    }

    public function registerProcess(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'type' => 'startup',
        ]);

        Auth::login($user);
        return redirect()->route('startup.dashboard');
    }


    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('login');
    }
}

