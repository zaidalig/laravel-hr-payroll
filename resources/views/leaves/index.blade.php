@extends('layouts.app')@section('title','Leaves')@section('page_title','Leave Requests')
@section('content')
<div class="d-flex justify-content-between mb-4"><p class="text-muted mb-0">Approve or reject employee leave requests.</p><a href="{{ route('leaves.create') }}" class="btn btn-primary rounded-pill"><i class="fa-solid fa-plus me-1"></i>New Leave Request</a></div>
<div class="card filter-card border-0 mb-4"><div class="card-body p-3"><form method="GET" class="row g-2">
<div class="col-md-3"><select name="employee_id" class="form-select form-select-compact"><option value="">All Employees</option>@foreach($employees as $e)<option value="{{ $e->id }}" @selected(request('employee_id')==$e->id)>{{ $e->name }}</option>@endforeach</select></div>
<div class="col-md-3"><select name="status" class="form-select form-select-compact"><option value="">All Statuses</option>@foreach(['pending','approved','rejected'] as $s)<option value="{{ $s }}" @selected(request('status')===$s)>{{ ucfirst($s) }}</option>@endforeach</select></div>
<div class="col-md-4 d-flex gap-2"><button class="btn btn-dark w-100">Filter</button>@if(request()->anyFilled(['employee_id','status']))<a href="{{ route('leaves.index') }}" class="btn btn-outline-secondary w-100">Clear</a>@endif</div>
</form></div></div>
<div class="card card-table border-0"><div class="table-responsive"><table class="table mb-0"><thead class="table-light"><tr><th>Employee</th><th>Type</th><th>From</th><th>To</th><th>Status</th><th>Reviewed By</th><th class="text-end">Actions</th></tr></thead><tbody>
@forelse($leaves as $leave)
<tr><td>{{ $leave->employee->name }}</td><td>{{ ucfirst($leave->type) }}</td><td>{{ $leave->start_date->format('M d, Y') }}</td><td>{{ $leave->end_date->format('M d, Y') }}</td>
<td><span class="badge {{ $leave->status==='approved'?'bg-success-subtle text-success':($leave->status==='rejected'?'bg-danger-subtle text-danger':'bg-warning-subtle text-warning') }}">{{ ucfirst($leave->status) }}</span></td>
<td>{{ $leave->reviewer?->name ?? '-' }}</td>
<td class="text-end"><div class="table-actions">@if($leave->status==='pending')
<form method="POST" action="{{ route('leaves.status',$leave) }}" class="d-inline">@csrf @method('PATCH')<input type="hidden" name="status" value="approved"><button class="btn btn-sm btn-outline-success" title="Approve"><i class="fa-solid fa-check"></i></button></form>
<form method="POST" action="{{ route('leaves.status',$leave) }}" class="d-inline">@csrf @method('PATCH')<input type="hidden" name="status" value="rejected"><button class="btn btn-sm btn-outline-warning" title="Reject"><i class="fa-solid fa-xmark"></i></button></form>
@endif
<button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-url="{{ route('leaves.destroy',$leave) }}" data-name="leave request"><i class="fa-solid fa-trash"></i></button></div></td></tr>
@empty<tr><td colspan="7" class="text-center py-4 text-muted">No leave requests.</td></tr>@endforelse
</tbody></table></div>@include('components.table-pagination', ['paginator'=>$leaves, 'sorts'=>['created_at'=>'Created','start_date'=>'Start','status'=>'Status']])</div>
@endsection
