<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use Carbon\Carbon;

class EmployeeController extends Controller
{
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
            'Role' => 'required|in:Admin,Cashier,Sales Person,Manager',
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
        $oldStatus = $employee->EmployeeStatus;
        
        $validated = $request->validate([
            'EmployeeFName' => 'required|string|max:50',
            'EmployeeLName' => 'required|string|max:50',
            'EmployeeMName' => 'nullable|string|max:1',
            'EmployeeContactNum' => 'required|string|max:20',
            'EmployeeEmail' => 'nullable|email|max:100',
            'Role' => 'required|in:Admin,Cashier,Sales Person,Manager',
            'EmployeeStatus' => 'required|in:Active,Inactive,On Leave'
        ]);

        $employee->update($validated);
        
        // Check if status changed to Inactive
        if ($oldStatus !== 'Inactive' && $validated['EmployeeStatus'] === 'Inactive') {
            $employeeName = trim("{$employee->EmployeeFName} " . ($employee->EmployeeMName ? $employee->EmployeeMName . '. ' : '') . "{$employee->EmployeeLName}");
            
            $message = "Employee {$employeeName} has been set to Inactive status. ";
            
            // Add role-specific consequences
            if (in_array($employee->Role, ['Cashier', 'Sales Person'])) {
                $message .= "This employee will lose system access and may be permanently removed after 30 days of inactivity.";
            } else {
                $message .= "This employee will lose system access.";
            }
            
            return redirect()->route('admin.employees')
                ->with('warning', $message)
                ->with('success', 'Employee updated successfully!');
        }
        
        return redirect()->route('admin.employees')->with('success', 'Employee updated successfully!');
    }

    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();
        
        return redirect()->route('admin.employees')->with('success', 'Employee deleted successfully!');
    }

    // New method to handle removal of inactive cashiers and sales persons
    public function removeInactiveEmployee($id)
    {
        $employee = Employee::findOrFail($id);
        
        // Check if employee is eligible for removal
        if (!in_array($employee->Role, ['Cashier', 'Sales Person']) || $employee->EmployeeStatus !== 'Inactive') {
            return redirect()->back()->with('error', 'Only inactive Cashiers and Sales Persons can be removed!');
        }
        
        if (!$employee->shouldBeRemoved()) {
            $daysInactive = Carbon::now()->diffInDays($employee->removed_at);
            $daysNeeded = 30 - $daysInactive;
            return redirect()->back()->with('warning', "{$employee->Role} needs to be inactive for {$daysNeeded} more day(s) before permanent removal.");
        }
        
        // Permanent removal logic
        $employee->delete();
        
        return redirect()->route('admin.employees')->with('success', "Inactive {$employee->Role} permanently removed!");
    }
    
    // Batch removal of eligible inactive employees (Cashiers and Sales Persons)
    public function batchRemoveInactiveEmployees()
    {
        $inactiveEmployees = Employee::whereIn('Role', ['Cashier', 'Sales Person'])
            ->where('EmployeeStatus', 'Inactive')
            ->whereNotNull('removed_at')
            ->get();
            
        $removedCount = 0;
        $removedRoles = [];
        
        foreach ($inactiveEmployees as $employee) {
            if ($employee->shouldBeRemoved()) {
                $role = $employee->Role;
                $employee->delete();
                $removedCount++;
                
                if (!isset($removedRoles[$role])) {
                    $removedRoles[$role] = 0;
                }
                $removedRoles[$role]++;
            }
        }
        
        if ($removedCount > 0) {
            $message = "{$removedCount} inactive employee(s) permanently removed!";
            if (!empty($removedRoles)) {
                $roleMessages = [];
                foreach ($removedRoles as $role => $count) {
                    $roleMessages[] = "{$count} {$role}(s)";
                }
                $message .= " (" . implode(", ", $roleMessages) . ")";
            }
            return redirect()->route('admin.employees')->with('success', $message);
        }
        
        return redirect()->route('admin.employees')->with('info', 'No eligible employees for removal at this time.');
    }

    public function getEmployees()
    {
        $employees = Employee::select('EmployeeID', 'EmployeeFName', 'EmployeeLName', 'EmployeeMName', 'Role')
            ->orderBy('EmployeeLName')
            ->get()
            ->map(function ($emp) {
                $emp->display_name = trim("{$emp->EmployeeFName} " . ($emp->EmployeeMName ? $emp->EmployeeMName . ' ' : '') . "{$emp->EmployeeLName}");
                $emp->emp_code = 'EMP' . str_pad($emp->EmployeeID, 3, '0', STR_PAD_LEFT);
                $emp->role_badge = $this->getRoleBadge($emp->Role);
                return $emp;
            });

        return response()->json($employees);
    }

    private function getRoleBadge($role)
    {
        $badgeClasses = [
            'Admin' => 'badge bg-danger',
            'Manager' => 'badge bg-warning',
            'Cashier' => 'badge bg-primary',
            'Sales Person' => 'badge bg-info'
        ];
        
        return '<span class="' . ($badgeClasses[$role] ?? 'badge bg-secondary') . '">' . $role . '</span>';
    }

    // Get employee statistics
    public function getEmployeeStats()
    {
        $totalEmployees = Employee::count();
        $activeEmployees = Employee::where('EmployeeStatus', 'Active')->count();
        $inactiveEmployees = Employee::where('EmployeeStatus', 'Inactive')->count();
        $onLeaveEmployees = Employee::where('EmployeeStatus', 'On Leave')->count();
        
        // Role distribution
        $roleDistribution = Employee::select('Role', \DB::raw('count(*) as count'))
            ->groupBy('Role')
            ->get()
            ->pluck('count', 'Role')
            ->toArray();
        
        return response()->json([
            'total' => $totalEmployees,
            'active' => $activeEmployees,
            'inactive' => $inactiveEmployees,
            'on_leave' => $onLeaveEmployees,
            'roles' => $roleDistribution
        ]);
    }

    // Activate employee
    public function activateEmployee($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->update([
            'EmployeeStatus' => 'Active',
            'removed_at' => null // Clear removal date if reactivated
        ]);
        
        return redirect()->route('admin.employees')->with('success', 'Employee activated successfully!');
    }

    // Deactivate employee
    public function deactivateEmployee($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->update([
            'EmployeeStatus' => 'Inactive',
            'removed_at' => Carbon::now() // Set removal date for tracking
        ]);
        
        return redirect()->route('admin.employees')->with('success', 'Employee deactivated successfully!');
    }

    // Set employee on leave
    public function setOnLeave($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->update([
            'EmployeeStatus' => 'On Leave',
            'removed_at' => null // Clear removal date
        ]);
        
        return redirect()->route('admin.employees')->with('success', 'Employee set to On Leave successfully!');
    }
}