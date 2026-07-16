@extends('layouts.app')@section('title','Payslip')@section('page_title','Payslip — '.$payroll->period)
@section('content')
<div class="card p-4 border-0 shadow-sm" style="max-width:640px">
<div class="d-flex justify-content-between mb-3"><div><h4 class="fw-bold mb-0">{{ $payroll->employee->name }}</h4><span class="text-muted">{{ $payroll->employee->employee_code }} | {{ $payroll->employee->department?->name ?? '-' }}</span></div><span class="badge {{ $payroll->status==='paid'?'bg-success-subtle text-success':'bg-warning-subtle text-warning' }} align-self-start px-3 py-2">{{ ucfirst($payroll->status) }}</span></div>
<table class="table">
<tr><td>Period</td><td class="text-end">{{ $payroll->period }}</td></tr>
<tr><td>Base Salary</td><td class="text-end">${{ number_format($payroll->base_salary,2) }}</td></tr>
<tr><td>Allowances</td><td class="text-end text-success">+ ${{ number_format($payroll->allowances,2) }}</td></tr>
<tr><td>Deductions</td><td class="text-end text-danger">− ${{ number_format($payroll->deductions,2) }}</td></tr>
<tr class="fw-bold"><td>Net Salary</td><td class="text-end">${{ number_format($payroll->net_salary,2) }}</td></tr>
@if($payroll->paid_at)<tr><td>Paid On</td><td class="text-end">{{ $payroll->paid_at->format('M d, Y') }}</td></tr>@endif
</table>
@if($payroll->status!=='paid')
<form method="POST" action="{{ route('payroll.paid',$payroll) }}">@csrf @method('PATCH')<button class="btn btn-success">Mark as Paid</button> <a href="{{ route('payroll.index') }}" class="btn btn-light">Back</a></form>
@else
<a href="{{ route('payroll.index') }}" class="btn btn-light">Back</a>
@endif
</div>
@endsection
