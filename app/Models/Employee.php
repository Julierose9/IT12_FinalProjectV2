<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Employee extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'EmployeeID',
        'EmployeeFName',
        'EmployeeLName',
        'EmployeeMName',
        'EmployeeContactNum',
        'Role',
        'EmployeeStatus',
        'removed_at'
    ];

    protected $dates = [
        'removed_at',
        'created_at',
        'updated_at'
    ];

    // Define the valid roles
    public const ROLES = [
        'Admin' => 'Admin',
        'Manager' => 'Manager',
        'Cashier' => 'Cashier',
        'Sales Person' => 'Sales Person'
    ];

    // Define the valid statuses
    public const STATUSES = [
        'Active' => 'Active',
        'Inactive' => 'Inactive',
        'On Leave' => 'On Leave'
    ];

    protected static function booted()
    {
        static::creating(function ($employee) {
            $latest = static::max('id');
            $nextId = $latest ? $latest + 1 : 1;
            $employee->EmployeeID = 'EMP' . str_pad($nextId, 3, '0', STR_PAD_LEFT);
        });

        // Auto-set removed_at when status changes to Inactive for Cashiers and Sales Persons
        static::updating(function ($employee) {
            if ($employee->isDirty('EmployeeStatus') && 
                $employee->EmployeeStatus === 'Inactive' && 
                in_array($employee->Role, ['Cashier', 'Sales Person'])) {
                $employee->removed_at = Carbon::now();
            }
            
            // If status changes back from Inactive, clear removed_at
            if ($employee->isDirty('EmployeeStatus') && 
                $employee->EmployeeStatus !== 'Inactive') {
                $employee->removed_at = null;
            }
        });
    }

    public function user()
    {
        return $this->hasOne(User::class, 'EmployeeID', 'EmployeeID');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'EmployeeID', 'EmployeeID');
    }

    // Get full name attribute
    public function getFullNameAttribute()
    {
        return trim("{$this->EmployeeFName} " . 
                    ($this->EmployeeMName ? $this->EmployeeMName . '. ' : '') . 
                    "{$this->EmployeeLName}");
    }

    // Get employee code
    public function getEmployeeCodeAttribute()
    {
        return 'EMP' . str_pad($this->EmployeeID, 3, '0', STR_PAD_LEFT);
    }

    // Get role badge class
    public function getRoleBadgeClassAttribute()
    {
        $classes = [
            'Admin' => 'badge bg-danger',
            'Manager' => 'badge bg-warning',
            'Cashier' => 'badge bg-primary',
            'Sales Person' => 'badge bg-info'
        ];
        
        return $classes[$this->Role] ?? 'badge bg-secondary';
    }

    // Get status badge class
    public function getStatusBadgeClassAttribute()
    {
        $classes = [
            'Active' => 'badge bg-success',
            'Inactive' => 'badge bg-secondary',
            'On Leave' => 'badge bg-warning'
        ];
        
        return $classes[$this->EmployeeStatus] ?? 'badge bg-secondary';
    }

    // Helper method to check if employee should be removed
    public function shouldBeRemoved(): bool
    {
        // Cashiers and Sales Persons who have been inactive for more than 30 days should be removed
        if (in_array($this->Role, ['Cashier', 'Sales Person']) && 
            $this->EmployeeStatus === 'Inactive' && 
            $this->removed_at) {
            
            $daysInactive = Carbon::now()->diffInDays($this->removed_at);
            return $daysInactive >= 30; // Remove after 30 days of inactivity
        }
        
        return false;
    }
    
    // Get days remaining before removal
    public function getDaysRemainingForRemoval(): ?int
    {
        if ($this->EmployeeStatus === 'Inactive' && $this->removed_at && in_array($this->Role, ['Cashier', 'Sales Person'])) {
            $daysInactive = Carbon::now()->diffInDays($this->removed_at);
            return max(0, 30 - $daysInactive);
        }
        
        return null;
    }
    
    // Method to get consequences of being inactive
    public function getInactiveConsequences(): array
    {
        if ($this->EmployeeStatus !== 'Inactive') {
            return [];
        }
        
        $consequences = [];
        
        if (in_array($this->Role, ['Cashier', 'Sales Person'])) {
            switch($this->Role) {
                case 'Cashier':
                    $consequences[] = 'Cannot access cash register';
                    $consequences[] = 'No longer receives schedule assignments';
                    break;
                case 'Sales Person':
                    $consequences[] = 'Cannot make sales transactions';
                    $consequences[] = 'Removed from sales team assignments';
                    break;
            }
            
            $consequences[] = 'System access revoked';
            
            $daysRemaining = $this->getDaysRemainingForRemoval();
            if ($daysRemaining !== null) {
                if ($daysRemaining > 0) {
                    $consequences[] = "Will be permanently removed in {$daysRemaining} day(s)";
                } else {
                    $consequences[] = 'Ready for permanent removal';
                }
            }
        }
        
        return $consequences;
    }

    // Check if employee can be deleted
    public function canBeDeleted(): bool
    {
        // Admins and Managers cannot be deleted if they're active
        if (in_array($this->Role, ['Admin', 'Manager']) && $this->EmployeeStatus === 'Active') {
            return false;
        }
        
        // Check if employee has associated records
        if ($this->orders()->count() > 0) {
            return false;
        }
        
        return true;
    }

    // Scope for active employees
    public function scopeActive($query)
    {
        return $query->where('EmployeeStatus', 'Active');
    }

    // Scope for inactive employees
    public function scopeInactive($query)
    {
        return $query->where('EmployeeStatus', 'Inactive');
    }

    // Scope for employees on leave
    public function scopeOnLeave($query)
    {
        return $query->where('EmployeeStatus', 'On Leave');
    }

    // Scope by role
    public function scopeByRole($query, $role)
    {
        return $query->where('Role', $role);
    }

    // Scope for employees eligible for removal
    public function scopeEligibleForRemoval($query)
    {
        return $query->whereIn('Role', ['Cashier', 'Sales Person'])
                    ->where('EmployeeStatus', 'Inactive')
                    ->whereNotNull('removed_at')
                    ->whereRaw('DATEDIFF(NOW(), removed_at) >= 30');
    }
}