<?php

namespace Tests\Feature;

use App\Models\Department;
use App\Models\Employee;
use App\Models\Payroll;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PayrollPrintTest extends TestCase
{
    use RefreshDatabase;

    protected function makePayroll(User $user): Payroll
    {
        $department = Department::create([
            'name' => 'Engineering',
            'status' => 'active',
        ]);

        $employee = Employee::create([
            'department_id' => $department->id,
            'employee_code' => 'EMP-001',
            'name' => 'Jane Doe',
            'designation' => 'Developer',
            'base_salary' => 5000,
            'joined_at' => today(),
            'status' => 'active',
        ]);

        return Payroll::create([
            'employee_id' => $employee->id,
            'period' => '2026-07',
            'base_salary' => 5000,
            'allowances' => 200,
            'deductions' => 50,
            'net_salary' => 5150,
            'status' => 'pending',
            'user_id' => $user->id,
        ]);
    }

    public function test_accountant_can_print_payslip(): void
    {
        $user = User::create([
            'name' => 'Accountant',
            'email' => 'acc-print@test.local',
            'password' => 'password',
            'role' => 'accountant',
            'status' => 'active',
        ]);

        $payroll = $this->makePayroll($user);

        $this->actingAs($user)
            ->get("/payroll/{$payroll->id}/print")
            ->assertOk()
            ->assertSee('Jane Doe')
            ->assertSee('5,150.00');
    }

    public function test_hr_cannot_print_payslip(): void
    {
        $accountant = User::create([
            'name' => 'Accountant',
            'email' => 'acc-print2@test.local',
            'password' => 'password',
            'role' => 'accountant',
            'status' => 'active',
        ]);

        $hr = User::create([
            'name' => 'HR',
            'email' => 'hr-print@test.local',
            'password' => 'password',
            'role' => 'hr',
            'status' => 'active',
        ]);

        $payroll = $this->makePayroll($accountant);

        $this->actingAs($hr)
            ->get("/payroll/{$payroll->id}/print")
            ->assertForbidden();
    }
}
