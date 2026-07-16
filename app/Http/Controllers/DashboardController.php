<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Attendance;
use App\Models\Department;
use App\Models\Employee;
use App\Models\LeaveRequest;
use App\Models\Payroll;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'employees' => Employee::where('status', 'active')->count(),
            'departments' => Department::where('status', 'active')->count(),
            'present_today' => Attendance::whereDate('attendance_date', today())->where('status', 'present')->count(),
            'pending_leaves' => LeaveRequest::where('status', 'pending')->count(),
            'pending_payrolls' => Payroll::where('status', 'pending')->count(),
        ];

        $pendingLeaves = LeaveRequest::with('employee')->where('status', 'pending')->latest()->limit(5)->get();
        $recentPayrolls = Payroll::with('employee')->latest()->limit(5)->get();
        $recentLogs = ActivityLog::with('user')->latest()->limit(8)->get();

        return view('dashboard', compact('stats', 'pendingLeaves', 'recentPayrolls', 'recentLogs'));
    }
}
