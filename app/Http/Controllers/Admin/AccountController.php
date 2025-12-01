<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;        // If you're using Eloquent User model
// Or remove this line if you keep using DB::table()

class AccountController extends Controller
{
    // 1. List all accounts
    public function index()
    {
        $accounts = DB::table('Users')
            ->leftJoin('Employees', 'Users.EmployeeID', '=', 'Employees.EmployeeID')
            ->select(
                'Users.UserID',
                'Users.Email',
                'Users.Role',
                'Users.created_at',
                'Users.updated_at',
                'Employees.EmployeeID',
                'Employees.EmployeeFName',
                'Employees.EmployeeLName',
                'Employees.EmployeeMName'
            )
            ->orderByDesc('Users.Role')
            ->orderBy('Employees.EmployeeLName')
            ->orderBy('Employees.EmployeeFName')
            ->get();

        // Build FullName, Username, and formatted EMP code
        $accounts = $accounts->map(function ($acc) {
            $middle = $acc->EmployeeMName ? trim($acc->EmployeeMName) . ' ' : '';
            $fullName = trim("{$acc->EmployeeFName} {$middle}{$acc->EmployeeLName}");

            $acc->FullName     = $fullName ?: '— (No Employee Linked)';
            $acc->Username     = $acc->Email ?? '—';
            $acc->EmpCode = $acc->EmployeeID 
    ? 'EMP' . str_pad($acc->EmployeeID, 3, '0', STR_PAD_LEFT)
    : null;

            return $acc;
        });

        return view('admin.accounts', compact('accounts'));
    }

    // 2. Show single account (View Details)
    public function show($id)
    {
        $account = DB::table('Users')
            ->leftJoin('Employees', 'Users.EmployeeID', '=', 'Employees.EmployeeID')
            ->where('Users.UserID', $id)
            ->select(
                'Users.*',
                'Employees.EmployeeFName',
                'Employees.EmployeeLName',
                'Employees.EmployeeMName',
                'Employees.EmployeeID'
            )
            ->first();

        if (!$account) {
            return redirect()->route('admin.accounts')->with('error', 'Account not found.');
        }

        $account->FullName = trim("{$account->EmployeeFName} " . ($account->EmployeeMName ? $account->EmployeeMName . ' ' : '') . "{$account->EmployeeLName}") 
            ?: '— (No Employee Linked)';

        return view('admin.accounts.show', compact('account'));
    }

    // 3. Show edit form
    public function edit($id)
    {
        $account = DB::table('Users')
            ->leftJoin('Employees', 'Users.EmployeeID', '=', 'Employees.EmployeeID')
            ->where('Users.UserID', $id)
            ->select('Users.*', 'Employees.EmployeeID as EmpID', 'Employees.EmployeeFName', 'Employees.EmployeeLName', 'Employees.EmployeeMName')
            ->first();

        $employees = DB::table('Employees')
            ->select('EmployeeID', 'EmployeeFName', 'EmployeeLName', 'EmployeeMName')
            ->orderBy('EmployeeLName')
            ->get();

        if (!$account) {
            return redirect()->route('admin.accounts')->with('error', 'Account not found.');
        }

        return view('admin.accounts.edit', compact('account', 'employees'));
    }

    // 4. Update account
    public function update(Request $request, $id)
    {
        $request->validate([
            'email'        => 'required|email|unique:Users,Email,' . $id . ',UserID',
            'role'         => 'required|in:Admin,Cashier',
            'employee_id'  => 'nullable|exists:Employees,EmployeeID',
            'password'     => 'nullable|min:6|confirmed',
        ]);

        $data = [
            'Email'       => $request->email,
            'Role'        => $request->role,
            'EmployeeID'  => $request->employee_id ?: null,
            'updated_at'  => now(),
        ];

        if ($request->filled('password')) {
            $data['Password'] = Hash::make($request->password);
        }

        DB::table('Users')->where('UserID', $id)->update($data);

        return redirect()->route('admin.accounts')->with('success', 'Account updated successfully!');
    }

    // 5. Delete account
    public function destroy($id)
    {
        $user = DB::table('Users')->where('UserID', $id)->first();

        if (!$user) {
            return redirect()->route('admin.accounts')->with('error', 'Account not found.');
        }

        // Prevent deleting your own account (optional safety)
        if (auth()->id() == $id) {
            return redirect()->route('admin.accounts')->with('error', 'You cannot delete your own account!');
        }

        DB::table('Users')->where('UserID', $id)->delete();

        return redirect()->route('admin.accounts')->with('success', 'Account deleted permanently.');
    }

    // 6. Store new account (from modal)
    public function store(Request $request)
    {
        $request->validate([
            'email'        => 'required|email|unique:Users,Email',
            'password'     => 'required|min:6|confirmed',
            'role'         => 'required|in:Admin,Cashier',
            'employee_id'  => 'nullable|exists:Employees,EmployeeID',
        ]);

        DB::table('Users')->insert([
            'Email'       => $request->email,
            'Password'    => Hash::make($request->password),
            'Role'        => $request->role,
            'EmployeeID'  => $request->employee_id ?: null,
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        return redirect()->route('admin.accounts')->with('success', 'New account created successfully!');
    }
}