@extends('layouts.app')@section('title','Generate Payroll')@section('page_title','Generate Payroll')
@section('content')<div class="card p-4 border-0 shadow-sm"><form method="POST" action="{{ route('payroll.store') }}">@csrf
<div class="row g-3">
<div class="col-md-6"><label class="form-label">Employee</label><select name="employee_id" class="form-select" required>@foreach($employees as $e)<option value="{{ $e->id }}">{{ $e->name }} — ${{ number_format($e->base_salary,2) }}/mo</option>@endforeach</select></div>
<div class="col-md-6"><label class="form-label">Period</label><input type="month" name="period" class="form-control" value="{{ date('Y-m') }}" required></div>
<div class="col-md-6"><label class="form-label">Allowances</label><input type="number" step="0.01" name="allowances" class="form-control" value="0"></div>
<div class="col-md-6"><label class="form-label">Deductions</label><input type="number" step="0.01" name="deductions" class="form-control" value="0"></div>
</div>
<p class="form-text mt-2">Net salary = base salary + allowances − deductions (base is taken from the employee profile).</p>
<div class="mt-3"><button class="btn btn-primary">Generate</button> <a href="{{ route('payroll.index') }}" class="btn btn-light">Cancel</a></div></form></div>@endsection
