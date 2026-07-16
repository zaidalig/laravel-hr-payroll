@extends('layouts.app')@section('title','Edit Department')@section('page_title','Edit Department')
@section('content')<div class="card p-4 border-0 shadow-sm"><form method="POST" action="{{ route('departments.update',$department) }}">@csrf @method('PUT')
<div class="mb-3"><label class="form-label">Name</label><input name="name" class="form-control" value="{{ old('name',$department->name) }}" required></div>
<div class="mb-3"><label class="form-label">Description</label><textarea name="description" class="form-control" rows="3">{{ old('description',$department->description) }}</textarea></div>
<div class="mb-3"><label class="form-label">Status</label><select name="status" class="form-select"><option value="active" @selected($department->status==='active')>Active</option><option value="inactive" @selected($department->status==='inactive')>Inactive</option></select></div>
<button class="btn btn-primary">Update</button> <a href="{{ route('departments.index') }}" class="btn btn-light">Cancel</a></form></div>@endsection
