<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\Department;
use App\Models\Employee;
use App\Models\LeaveRequest;
use App\Models\Payroll;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['name' => 'Company Owner', 'email' => 'owner@example.com', 'password' => 'password', 'role' => 'owner', 'status' => 'active'],
            ['name' => 'HR Manager', 'email' => 'hr@example.com', 'password' => 'password', 'role' => 'hr', 'status' => 'active'],
            ['name' => 'Chief Accountant', 'email' => 'accountant@example.com', 'password' => 'password', 'role' => 'accountant', 'status' => 'active'],
            ['name' => 'Read Only', 'email' => 'viewer@example.com', 'password' => 'password', 'role' => 'viewer', 'status' => 'inactive'],
        ];

        foreach ($users as $user) {
            User::create($user);
        }

        $departments = [
            ['name' => 'Engineering', 'description' => 'Product development'],
            ['name' => 'Sales', 'description' => 'Sales and business development'],
            ['name' => 'Operations', 'description' => 'Admin and operations'],
        ];

        foreach ($departments as $department) {
            Department::create($department + ['status' => 'active']);
        }

        $employees = [
            ['department_id' => 1, 'employee_code' => 'EMP-001', 'name' => 'Ali Hassan', 'email' => 'ali@company.test', 'designation' => 'Senior Developer', 'base_salary' => 3500, 'joined_at' => '2024-03-01'],
            ['department_id' => 1, 'employee_code' => 'EMP-002', 'name' => 'Sara Khan', 'email' => 'sara@company.test', 'designation' => 'QA Engineer', 'base_salary' => 2400, 'joined_at' => '2024-06-15'],
            ['department_id' => 2, 'employee_code' => 'EMP-003', 'name' => 'Bilal Ahmed', 'email' => 'bilal@company.test', 'designation' => 'Sales Executive', 'base_salary' => 1800, 'joined_at' => '2025-01-10'],
            ['department_id' => 3, 'employee_code' => 'EMP-004', 'name' => 'Nadia Iqbal', 'email' => 'nadia@company.test', 'designation' => 'Office Manager', 'base_salary' => 2000, 'joined_at' => '2023-11-20'],
        ];

        foreach ($employees as $employee) {
            Employee::create($employee + ['status' => 'active', 'phone' => '+92 300 0000000']);
        }

        foreach ([1, 2, 3, 4] as $employeeId) {
            Attendance::create([
                'employee_id' => $employeeId,
                'attendance_date' => today(),
                'status' => $employeeId === 3 ? 'late' : 'present',
                'check_in' => $employeeId === 3 ? '09:45:00' : '09:00:00',
                'check_out' => null,
            ]);
        }

        LeaveRequest::create([
            'employee_id' => 2,
            'type' => 'sick',
            'start_date' => today()->addDays(2),
            'end_date' => today()->addDays(3),
            'reason' => 'Medical appointment',
            'status' => 'pending',
        ]);

        $period = now()->subMonth()->format('Y-m');

        foreach (Employee::all() as $employee) {
            Payroll::create([
                'employee_id' => $employee->id,
                'period' => $period,
                'base_salary' => $employee->base_salary,
                'allowances' => 100,
                'deductions' => 50,
                'net_salary' => $employee->base_salary + 50,
                'status' => 'paid',
                'paid_at' => now()->startOfMonth(),
                'user_id' => 3,
            ]);
        }
    }
}
