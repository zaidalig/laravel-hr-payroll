@extends('layouts.app')@section('title','Employees')@section('page_title','Employees')
@section('content')
<div class="d-flex justify-content-between mb-4"><p class="text-muted mb-0">Employee directory and profiles.</p><a href="{{ route('employees.create') }}" class="btn btn-primary rounded-pill">Add Employee</a></div>
<div class="card filter-card border-0 mb-4"><div class="card-body p-3"><form method="GET" class="row g-2">
<div class="col-md-4"><input name="search" class="form-control" placeholder="Search name, code, designation" value="{{ request('search') }}"></div>
<div class="col-md-3"><select name="department_id" class="form-select"><option value="">All Departments</option>@foreach($departments as $d)<option value="{{ $d->id }}" @selected(request('department_id')==$d->id)>{{ $d->name }}</option>@endforeach</select></div>
<div class="col-md-2"><select name="status" class="form-select"><option value="">All Status</option>@foreach(['active','inactive','terminated'] as $s)<option value="{{ $s }}" @selected(request('status')===$s)>{{ ucfirst($s) }}</option>@endforeach</select></div>
<div class="col-md-3 d-flex gap-2"><button class="btn btn-dark w-100">Filter</button>@if(request()->anyFilled(['search','department_id','status']))<a href="{{ route('employees.index') }}" class="btn btn-outline-secondary w-100">Clear</a>@endif</div>
</form></div></div>
<div class="card card-table border-0"><div class="table-responsive"><table class="table mb-0"><thead class="table-light"><tr><th>Code</th><th>Name</th><th>Department</th><th>Designation</th><th>Salary</th><th>Status</th><th class="text-end">Actions</th></tr></thead><tbody>
@forelse($employees as $e)
<tr><td>{{ $e->employee_code }}</td><td><a href="{{ route('employees.show',$e) }}" class="fw-bold text-decoration-none">{{ $e->name }}</a></td><td>{{ $e->department?->name ?? '-' }}</td><td>{{ $e->designation }}</td><td>${{ number_format($e->base_salary,2) }}</td><td><span class="badge {{ $e->status==='active'?'bg-success-subtle text-success':'bg-danger-subtle text-danger' }}">{{ ucfirst($e->status) }}</span></td>
<td class="text-end"><a href="{{ route('employees.edit',$e) }}" class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-pen"></i></a> <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-url="{{ route('employees.destroy',$e) }}" data-name="{{ $e->name }}"><i class="fa-solid fa-trash"></i></button></td></tr>
@empty<tr><td colspan="7" class="text-center py-4 text-muted">No employees found.</td></tr>@endforelse
</tbody></table></div>@if($employees->hasPages())<div class="card-footer bg-white">{{ $employees->links() }}</div>@endif</div>
@endsection
