<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    // In your controller
public function index()
{
    $employees = Employee::leftJoin('users', 'employees.EmployeeID', '=', 'users.EmployeeID')
        ->select('employees.*', 'users.email as EmployeeEmail')
        ->get();

    return view('admin.employees', compact('employees'));
}

    public function store(Request $request)
    {
        $validated = $request->validate([
            'EmployeeFName' => 'required|string|max:50',
            'EmployeeLName' => 'required|string|max:50',
            'EmployeeMName' => 'nullable|string|max:1',
            'EmployeeContactNum' => 'required|string|max:20',
            'Role' => 'required|in:Admin,Cashier,Manager',
            'EmployeeStatus' => 'required|in:Active,Inactive,On Leave'
        ]);

        Employee::create($validated);
        
        return redirect()->route('admin.employees')->with('success', 'Employee added successfully!');
    }

    public function show($id)
    {
        $employee = Employee::findOrFail($id);
        return response()->json($employee);
    }

    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);
        
        $validated = $request->validate([
            'EmployeeFName' => 'required|string|max:50',
            'EmployeeLName' => 'required|string|max:50',
            'EmployeeMName' => 'nullable|string|max:1',
            'EmployeeContactNum' => 'required|string|max:20',
            'EmployeeEmail' => 'nullable|email|max:100',
            'Role' => 'required|in:Admin,Cashier,Manager',
            'EmployeeStatus' => 'required|in:Active,Inactive,On Leave'
        ]);

        $employee->update($validated);
        
        return redirect()->route('admin.employees')->with('success', 'Employee updated successfully!');
    }

    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();
        
        return redirect()->route('admin.employees')->with('success', 'Employee deleted successfully!');
    }

    public function getEmployees()
    {
        $employees = Employee::select('EmployeeID', 'EmployeeFName', 'EmployeeLName', 'EmployeeMName')
            ->orderBy('EmployeeLName')
            ->get()
            ->map(function ($emp) {
                $emp->display_name = trim("{$emp->EmployeeFName} " . ($emp->EmployeeMName ? $emp->EmployeeMName . ' ' : '') . "{$emp->EmployeeLName}");
                $emp->emp_code = 'EMP' . str_pad($emp->EmployeeID, 3, '0', STR_PAD_LEFT);
                return $emp;
            });

        return response()->json($employees);
    }
}