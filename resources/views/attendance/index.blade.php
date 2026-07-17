@extends('layouts.app')@section('title','Attendance')@section('page_title','Attendance')
@section('content')
<div class="d-flex justify-content-between mb-4"><p class="text-muted mb-0">Daily attendance records.</p><a href="{{ route('attendance.create') }}" class="btn btn-primary rounded-pill">Mark Attendance</a></div>
<div class="card filter-card border-0 mb-4"><div class="card-body p-3"><form method="GET" class="row g-2">
<div class="col-md-3"><input type="date" name="date" class="form-control" value="{{ request('date') }}"></div>
<div class="col-md-3"><select name="employee_id" class="form-select form-select-compact"><option value="">All Employees</option>@foreach($employees as $e)<option value="{{ $e->id }}" @selected(request('employee_id')==$e->id)>{{ $e->name }}</option>@endforeach</select></div>
<div class="col-md-2"><select name="status" class="form-select form-select-compact"><option value="">All Status</option>@foreach(['present','absent','late','half_day','leave'] as $s)<option value="{{ $s }}" @selected(request('status')===$s)>{{ ucfirst(str_replace('_',' ',$s)) }}</option>@endforeach</select></div>
<div class="col-md-4 d-flex gap-2"><button class="btn btn-dark w-100">Filter</button>@if(request()->anyFilled(['date','employee_id','status']))<a href="{{ route('attendance.index') }}" class="btn btn-outline-secondary w-100">Clear</a>@endif</div>
</form></div></div>
<div class="card card-table border-0"><div class="table-responsive"><table class="table mb-0"><thead class="table-light"><tr><th>Employee</th><th>Date</th><th>Status</th><th>In</th><th>Out</th><th class="text-end">Actions</th></tr></thead><tbody>
@forelse($attendances as $a)
<tr><td>{{ $a->employee->name }}</td><td>{{ $a->attendance_date->format('M d, Y') }}</td><td><span class="badge bg-light text-dark border">{{ ucfirst(str_replace('_',' ',$a->status)) }}</span></td><td>{{ $a->check_in ?? '-' }}</td><td>{{ $a->check_out ?? '-' }}</td>
<td class="text-end"><div class="table-actions"><a href="{{ route('attendance.edit',$a) }}" class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-pen"></i></a> <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-url="{{ route('attendance.destroy',$a) }}" data-name="attendance record"><i class="fa-solid fa-trash"></i></button></div></td></tr>
@empty<tr><td colspan="6" class="text-center py-4 text-muted">No attendance records.</td></tr>@endforelse
</tbody></table></div>@include('components.table-pagination', ['paginator'=>$attendances, 'sorts'=>['attendance_date'=>'Date','created_at'=>'Created','status'=>'Status']])</div>
@endsection
