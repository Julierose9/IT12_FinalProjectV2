<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    // 1. List all accounts
    public function index()
    {
        $accounts = DB::table('users')
            ->leftJoin('Employees', 'users.EmployeeID', '=', 'Employees.EmployeeID')
            ->select(
                'users.UserID',
                'users.email as Email',
                'users.Role as UserRole', // Alias to avoid conflict
                'users.created_at',
                'users.updated_at',
                'Employees.EmployeeID',
                'Employees.EmployeeFName',
                'Employees.EmployeeLName',
                'Employees.EmployeeMName',
                'Employees.Role as EmployeeRole' // Alias to distinguish from user role
            )
            ->orderByDesc('users.Role')
            ->orderBy('Employees.EmployeeLName')
            ->orderBy('Employees.EmployeeFName')
            ->get();

        // Build FullName, Username
        $accounts = $accounts->map(function ($acc) {
            $middle = $acc->EmployeeMName ? trim($acc->EmployeeMName) . ' ' : '';
            $fullName = trim("{$acc->EmployeeFName} {$middle}{$acc->EmployeeLName}");

            $acc->FullName = $fullName ?: '— (No Employee Linked)';
            $acc->Username = $acc->Email ?? '—';
            $acc->Role = $acc->UserRole; // Use the user role for display

            return $acc;
        });

        // Get employees for dropdown - Only Cashier and Admin employees
        $allEmployees = DB::table('Employees')
            ->whereIn('Role', ['Cashier', 'Admin']) // Capital R
            ->select(
                'EmployeeID', 
                'EmployeeFName', 
                'EmployeeLName', 
                'EmployeeMName',
                'Role'  // Capital R
            )
            ->orderBy('EmployeeLName')
            ->get();

        // Get employees with existing accounts
        $employeesWithAccounts = DB::table('users')
            ->whereNotNull('EmployeeID')
            ->pluck('EmployeeID')
            ->toArray();

        return view('admin.accounts', compact('accounts', 'allEmployees', 'employeesWithAccounts'));
    }

    // 2. Show single account (View Details)
    public function show($id)
    {
        $account = DB::table('users')
            ->leftJoin('Employees', 'users.EmployeeID', '=', 'Employees.EmployeeID')
            ->where('users.UserID', $id)
            ->select(
                'users.*',
                'Employees.EmployeeFName',
                'Employees.EmployeeLName',
                'Employees.EmployeeMName',
                'Employees.EmployeeID',
                'Employees.Role as EmployeeRole'
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
        $account = DB::table('users')
            ->leftJoin('Employees', 'users.EmployeeID', '=', 'Employees.EmployeeID')
            ->where('users.UserID', $id)
            ->select(
                'users.*', 
                'Employees.EmployeeID as EmpID', 
                'Employees.EmployeeFName', 
                'Employees.EmployeeLName', 
                'Employees.EmployeeMName',
                'Employees.Role as EmployeeRole'
            )
            ->first();

        $employees = DB::table('Employees')
            ->select('EmployeeID', 'EmployeeFName', 'EmployeeLName', 'EmployeeMName', 'Role')
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
            'email'        => 'required|email|unique:users,email,' . $id . ',UserID',
            'role'         => 'required|in:Admin,Cashier',
            'employee_id'  => 'nullable|exists:Employees,EmployeeID',
            'password'     => 'nullable|min:6',
        ]);

        $data = [
            'email'       => $request->email,
            'Role'        => $request->role, // Capital R
            'EmployeeID'  => $request->employee_id ?: null,
            'updated_at'  => now(),
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        DB::table('users')->where('UserID', $id)->update($data);

        return redirect()->route('admin.accounts')->with('success', 'Account updated successfully!');
    }

    // 5. Delete account
    public function destroy($id)
    {
        $user = DB::table('users')->where('UserID', $id)->first();

        if (!$user) {
            return redirect()->route('admin.accounts')->with('error', 'Account not found.');
        }

        // Prevent deleting your own account (optional safety)
        if (auth()->id() == $id) {
            return redirect()->route('admin.accounts')->with('error', 'You cannot delete your own account!');
        }

        DB::table('users')->where('UserID', $id)->delete();

        return redirect()->route('admin.accounts')->with('success', 'Account deleted permanently.');
    }

    // 6. Store new account
    public function store(Request $request)
    {
        $request->validate([
            'email'        => 'required|email|unique:users,email',
            'password'     => 'required|min:6',
            'role'         => 'required|in:Admin,Cashier',
            'employee_id'  => 'required|exists:Employees,EmployeeID',
        ]);

        // Check if employee already has an account
        $existingAccount = DB::table('users')->where('EmployeeID', $request->employee_id)->first();
        if ($existingAccount) {
            return redirect()->route('admin.accounts')->with('error', 'This employee already has an account.');
        }

        // Check if employee has valid Role (Cashier or Admin)
        $employee = DB::table('Employees')->where('EmployeeID', $request->employee_id)->first();
        if (!$employee) {
            return redirect()->route('admin.accounts')->with('error', 'Employee not found.');
        }

        // Check if employee Role is Cashier or Admin (Capital R)
        if (!in_array($employee->Role, ['Cashier', 'Admin'])) {
            return redirect()->route('admin.accounts')->with('error', 'Only employees with Cashier or Admin Role can have accounts.');
        }

        // Generate UserID (e.g., USR001)
        $lastUser = DB::table('users')->orderBy('UserID', 'desc')->first();
        if ($lastUser) {
            $lastId = (int) substr($lastUser->UserID, 3);
            $newId = 'USR' . str_pad($lastId + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $newId = 'USR001';
        }

        DB::table('users')->insert([
            'UserID'      => $newId,
            'email'       => $request->email,
            'password'    => Hash::make($request->password),
            'Role'        => $request->role, // Capital R
            'EmployeeID'  => $request->employee_id,
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        return redirect()->route('admin.accounts')->with('success', 'New account created successfully!');
    }
}