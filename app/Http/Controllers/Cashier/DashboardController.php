<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Check if user is authenticated and is cashier
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Check if user is cashier
        if (Auth::user()->Role !== 'Cashier') {
            abort(403, 'Unauthorized access. Cashier role required.');
        }

        return view('cashier.dashboard', [
            'user' => Auth::user()
        ]);
    }
}