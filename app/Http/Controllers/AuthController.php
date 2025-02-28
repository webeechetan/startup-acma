<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            'password' => 'required',
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

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('login');
    }
}

