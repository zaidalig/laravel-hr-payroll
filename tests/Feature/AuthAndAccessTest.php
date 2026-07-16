<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthAndAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_to_login(): void
    {
        $this->get('/')->assertRedirect('/login');
    }

    public function test_owner_can_view_dashboard(): void
    {
        $user = User::create([
            'name' => 'Owner',
            'email' => 'owner@test.local',
            'password' => 'password',
            'role' => 'owner',
            'status' => 'active',
        ]);

        $this->actingAs($user)->get('/')->assertOk();
    }

    public function test_owner_can_access_all_modules(): void
    {
        $user = User::create([
            'name' => 'Owner',
            'email' => 'owner-all@test.local',
            'password' => 'password',
            'role' => 'owner',
            'status' => 'active',
        ]);

        $this->actingAs($user)->get('/employees')->assertOk();
        $this->actingAs($user)->get('/payroll')->assertOk();
        $this->actingAs($user)->get('/users')->assertOk();
    }

    public function test_hr_can_manage_employees_but_not_payroll(): void
    {
        $user = User::create([
            'name' => 'HR',
            'email' => 'hr@test.local',
            'password' => 'password',
            'role' => 'hr',
            'status' => 'active',
        ]);

        $this->actingAs($user)->get('/employees')->assertOk();
        $this->actingAs($user)->get('/leaves')->assertOk();
        $this->actingAs($user)->get('/payroll')->assertForbidden();
    }

    public function test_accountant_can_manage_payroll_but_not_employees(): void
    {
        $user = User::create([
            'name' => 'Accountant',
            'email' => 'acc@test.local',
            'password' => 'password',
            'role' => 'accountant',
            'status' => 'active',
        ]);

        $this->actingAs($user)->get('/payroll')->assertOk();
        $this->actingAs($user)->get('/employees')->assertForbidden();
    }
}
