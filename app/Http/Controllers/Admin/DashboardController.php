<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Check if user is authenticated and is admin
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Check if user is admin
        if (Auth::user()->Role !== 'Admin') {
            abort(403, 'Unauthorized access. Admin role required.');
        }

        return view('admin.dashboard', [
            'user' => Auth::user()
        ]);
    }
}