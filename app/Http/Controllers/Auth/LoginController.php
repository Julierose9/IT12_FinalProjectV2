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
            return $this->redirectBasedOnRole();
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $remember = $request->has('remember'); // Fixed: use has() not filled()

        // THIS IS THE KEY: Use 'email' field exactly as in DB
        if (Auth::attempt([
            'email'    => $request->email,
            'password' => $request->password
        ], $remember)) {
            $request->session()->regenerate();

            \Log::info('Login Success: ' . Auth::user()->email . ' | Role: ' . Auth::user()->Role);

            return $this->redirectBasedOnRole();
        }

        // Show error if credentials wrong
        return back()->withErrors([
            'email' => 'The provided credentials are incorrect.',
        ])->withInput($request->only('email'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Logged out successfully!');
    }

    private function redirectBasedOnRole()
    {
        return match (Auth::user()->Role) {
            'Admin'   => redirect()->route('admin.dashboard'),
            'Cashier' => redirect()->route('cashier.dashboard'),
            default   => redirect()->route('login')
                ->withErrors(['email' => 'Your role is not authorized. Contact admin.']),
        };
    }
}