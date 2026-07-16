@extends('layouts.app')@section('title',$employee->name)@section('page_title',$employee->name)
@section('content')
<div class="row g-4">
<div class="col-lg-4"><div class="card p-4 border-0 shadow-sm"><h4 class="fw-bold mb-1">{{ $employee->name }}</h4><p class="text-muted mb-2">{{ $employee->employee_code }} | {{ $employee->designation }}</p>
<p class="mb-1"><i class="fa-solid fa-building-user me-2 text-muted"></i>{{ $employee->department?->name ?? 'No department' }}</p>
<p class="mb-1"><i class="fa-regular fa-envelope me-2 text-muted"></i>{{ $employee->email ?? '-' }}</p>
<p class="mb-1"><i class="fa-solid fa-phone me-2 text-muted"></i>{{ $employee->phone ?? '-' }}</p>
<p class="mb-1"><i class="fa-solid fa-money-bill me-2 text-muted"></i>${{ number_format($employee->base_salary,2) }}/month</p>
<p class="mb-3"><i class="fa-solid fa-calendar me-2 text-muted"></i>Joined {{ $employee->joined_at->format('M d, Y') }}</p>
<a href="{{ route('employees.edit',$employee) }}" class="btn btn-sm btn-outline-primary">Edit Profile</a></div></div>
<div class="col-lg-8">
<div class="card card-table border-0 mb-4"><div class="card-header bg-white fw-bold">Recent Attendance</div><div class="table-responsive"><table class="table mb-0"><thead class="table-light"><tr><th>Date</th><th>Status</th><th>In</th><th>Out</th></tr></thead><tbody>@forelse($employee->attendances as $a)<tr><td>{{ $a->attendance_date->format('M d, Y') }}</td><td>{{ ucfirst(str_replace('_',' ',$a->status)) }}</td><td>{{ $a->check_in ?? '-' }}</td><td>{{ $a->check_out ?? '-' }}</td></tr>@empty<tr><td colspan="4" class="text-center py-3 text-muted">No attendance records.</td></tr>@endforelse</tbody></table></div></div>
<div class="card card-table border-0"><div class="card-header bg-white fw-bold">Payroll History</div><div class="table-responsive"><table class="table mb-0"><thead class="table-light"><tr><th>Period</th><th>Net Salary</th><th>Status</th></tr></thead><tbody>@forelse($employee->payrolls as $p)<tr><td>{{ $p->period }}</td><td>${{ number_format($p->net_salary,2) }}</td><td>{{ ucfirst($p->status) }}</td></tr>@empty<tr><td colspan="3" class="text-center py-3 text-muted">No payroll records.</td></tr>@endforelse</tbody></table></div></div>
</div>
</div>
@endsection
