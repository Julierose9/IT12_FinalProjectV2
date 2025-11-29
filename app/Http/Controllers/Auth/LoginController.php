<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route(Auth::user()->Role === 'Admin' ? 'admin.dashboard' : 'cashier.dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Try to log the user in
        if (Auth::attempt($credentials, $request->has('remember'))) {
            
            // THIS IS CRITICAL
            $request->session()->regenerate();

            $user = Auth::user();

            // Optional: Log for debugging
            \Log::info('Login SUCCESS', ['user' => $user->email, 'role' => $user->Role]);

            // Redirect based on role
            return redirect()->intended(
                $user->Role === 'Admin' ? route('admin.dashboard') : route('cashier.dashboard')
            );
        }

        // Login failed
        return back()->withErrors([
            'email' => 'The provided credentials are incorrect.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Logged out successfully!');
    }
}