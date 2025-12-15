<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Employee;
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
            $user = Auth::user();
            
            // Check if employee is inactive
            if ($user->EmployeeID) {
                $employee = Employee::where('EmployeeID', $user->EmployeeID)->first();
                
                if ($employee && $employee->EmployeeStatus === 'Inactive') {
                    Auth::logout();
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();
                    
                    return back()->withErrors([
                        'email' => 'Your account is inactive. Please contact the administrator for assistance.',
                    ])->withInput($request->only('email'));
                }
            }
            
            $request->session()->regenerate();

            \Log::info('Login Success: ' . $user->email . ' | Role: ' . $user->Role);

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