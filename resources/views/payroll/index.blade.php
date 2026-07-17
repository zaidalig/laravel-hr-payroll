@extends('layouts.app')@section('title','Payroll')@section('page_title','Payroll')
@section('content')
<div class="d-flex justify-content-between mb-4"><p class="text-muted mb-0">Monthly salary slips.</p><a href="{{ route('payroll.create') }}" class="btn btn-primary rounded-pill">Generate Payroll</a></div>
<div class="card filter-card border-0 mb-4"><div class="card-body p-3"><form method="GET" class="row g-2">
<div class="col-md-3"><input type="month" name="period" class="form-control" value="{{ request('period') }}"></div>
<div class="col-md-3"><select name="status" class="form-select form-select-compact"><option value="">All Statuses</option>@foreach(['pending','paid'] as $s)<option value="{{ $s }}" @selected(request('status')===$s)>{{ ucfirst($s) }}</option>@endforeach</select></div>
<div class="col-md-4 d-flex gap-2"><button class="btn btn-dark w-100">Filter</button>@if(request()->anyFilled(['period','status']))<a href="{{ route('payroll.index') }}" class="btn btn-outline-secondary w-100">Clear</a>@endif</div>
</form></div></div>
<div class="card card-table border-0"><div class="table-responsive"><table class="table mb-0"><thead class="table-light"><tr><th>Employee</th><th>Period</th><th>Base</th><th>Allowances</th><th>Deductions</th><th>Net</th><th>Status</th><th class="text-end">Actions</th></tr></thead><tbody>
@forelse($payrolls as $p)
<tr><td>{{ $p->employee->name }}</td><td>{{ $p->period }}</td><td>${{ number_format($p->base_salary,2) }}</td><td>${{ number_format($p->allowances,2) }}</td><td>${{ number_format($p->deductions,2) }}</td><td class="fw-bold">${{ number_format($p->net_salary,2) }}</td>
<td><span class="badge {{ $p->status==='paid'?'bg-success-subtle text-success':'bg-warning-subtle text-warning' }}">{{ ucfirst($p->status) }}</span></td>
<td class="text-end"><div class="table-actions"><a href="{{ route('payroll.show',$p) }}" class="btn btn-sm btn-outline-info"><i class="fa-solid fa-eye"></i></a> <a href="{{ route('payroll.print',$p) }}" target="_blank" class="btn btn-sm btn-outline-secondary" title="Print Payslip"><i class="fa-solid fa-print"></i></a>
@if($p->status!=='paid')
<form method="POST" action="{{ route('payroll.paid',$p) }}" class="d-inline">@csrf @method('PATCH')<button class="btn btn-sm btn-outline-success" title="Mark Paid"><i class="fa-solid fa-check"></i></button></form>
<button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-url="{{ route('payroll.destroy',$p) }}" data-name="payroll {{ $p->period }}"><i class="fa-solid fa-trash"></i></button>
@endif</div></td></tr>
@empty<tr><td colspan="8" class="text-center py-4 text-muted">No payrolls generated.</td></tr>@endforelse
</tbody></table></div>@include('components.table-pagination', ['paginator'=>$payrolls, 'sorts'=>['created_at'=>'Created','period'=>'Period','net_salary'=>'Net','status'=>'Status']])</div>
@endsection
