<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * Show the login form
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle the login attempt
     */
    public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $credentials = $request->only('email', 'password');
    $remember = $request->filled('remember');

    if (Auth::attempt($credentials, $remember)) {
        $request->session()->regenerate();

        $user = Auth::user();
        
        // Add logging to confirm login
        \Log::info('Login successful for user: ' . $user->email . ' | Role: ' . $user->Role);

        if ($user->Role === 'Admin') {
            return redirect()->intended(route('admin.dashboard'));
        }

        if ($user->Role === 'Cashier') {
            return redirect()->intended(route('cashier.dashboard'));
        }

        Auth::logout();
        return redirect()->route('login')->withErrors(['email' => 'Unauthorized role.']);
    }

    // Login failed
    \Log::warning('Login failed for email: ' . $request->email);

    return back()->withErrors([
        'email' => 'The provided credentials are incorrect.',
    ])->onlyInput('email');
}

        

    /**
     * Handle user logout
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'You have been logged out successfully.');
    }
}