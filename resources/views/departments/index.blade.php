@extends('layouts.app')@section('title','Departments')@section('page_title','Departments')
@section('content')
<div class="d-flex justify-content-between mb-4"><p class="text-muted mb-0">Company departments.</p><a href="{{ route('departments.create') }}" class="btn btn-primary rounded-pill">Add Department</a></div>
<div class="card filter-card border-0 mb-4"><div class="card-body p-3"><form method="GET" class="row g-2"><div class="col-md-5"><input name="search" class="form-control" placeholder="Search name" value="{{ request('search') }}"></div><div class="col-md-3"><select name="status" class="form-select"><option value="">All</option><option value="active" @selected(request('status')==='active')>Active</option><option value="inactive" @selected(request('status')==='inactive')>Inactive</option></select></div><div class="col-md-4 d-flex gap-2"><button class="btn btn-dark w-100">Filter</button>@if(request()->anyFilled(['search','status']))<a href="{{ route('departments.index') }}" class="btn btn-outline-secondary w-100">Clear</a>@endif</div></form></div></div>
<div class="card card-table border-0"><div class="table-responsive"><table class="table mb-0"><thead class="table-light"><tr><th>Name</th><th>Employees</th><th>Status</th><th class="text-end">Actions</th></tr></thead><tbody>
@forelse($departments as $d)
<tr><td class="fw-bold">{{ $d->name }}</td><td>{{ $d->employees_count }}</td><td><span class="badge {{ $d->status==='active'?'bg-success-subtle text-success':'bg-danger-subtle text-danger' }}">{{ ucfirst($d->status) }}</span></td>
<td class="text-end"><a href="{{ route('departments.edit',$d) }}" class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-pen"></i></a> <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-url="{{ route('departments.destroy',$d) }}" data-name="{{ $d->name }}"><i class="fa-solid fa-trash"></i></button></td></tr>
@empty<tr><td colspan="4" class="text-center py-4 text-muted">No departments found.</td></tr>@endforelse
</tbody></table></div>@if($departments->hasPages())<div class="card-footer bg-white">{{ $departments->links() }}</div>@endif</div>
@endsection
