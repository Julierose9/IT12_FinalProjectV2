<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    /**
     * Show the login form
     */
    public function showLoginForm()
    {
        // Clear any leftover password reset sessions
        Session::forget('reset_email');
        
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

            // Role-based redirection (Note: Using $user->Role with capital R)
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
     * Verify email for password reset (Modal Step 1)
     */
    public function verifyEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        
        // Check if user exists
        $user = User::where('email', $request->email)->first();
        
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'No account found with that email address.'
            ], 404);
        }
        
        // Store email in session for verification (temporary for modal)
        Session::put('reset_email', $request->email);
        
        return response()->json([
            'success' => true,
            'message' => 'Email verified. You can now reset your password.'
        ]);
    }

    /**
     * Reset the user's password (Modal Step 2)
     */
    public function resetPassword(Request $request)
    {
        // Verify email from session
        $email = Session::get('reset_email');
        
        if (!$email) {
            return response()->json([
                'success' => false,
                'message' => 'Session expired. Please verify your email again.'
            ], 401);
        }
        
        $request->validate([
            'password' => 'required|confirmed|min:6',
        ]);
        
        // Find user and update password
        $user = User::where('email', $email)->first();
        
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found.'
            ], 404);
        }
        
        $user->password = Hash::make($request->password);
        $user->save();
        
        // Clear session
        Session::forget('reset_email');
        
        return response()->json([
            'success' => true,
            'message' => 'Password reset successfully! You can now login with your new password.'
        ]);
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