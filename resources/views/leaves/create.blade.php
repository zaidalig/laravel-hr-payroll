@extends('layouts.app')@section('title','New Leave')@section('page_title','New Leave Request')
@section('content')<div class="card p-4 border-0 shadow-sm"><form method="POST" action="{{ route('leaves.store') }}">@csrf
<div class="row g-3">
<div class="col-md-6"><label class="form-label">Employee</label><select name="employee_id" class="form-select" required>@foreach($employees as $e)<option value="{{ $e->id }}">{{ $e->name }}</option>@endforeach</select></div>
<div class="col-md-6"><label class="form-label">Type</label><select name="type" class="form-select">@foreach(['casual','sick','annual','unpaid'] as $t)<option value="{{ $t }}">{{ ucfirst($t) }}</option>@endforeach</select></div>
<div class="col-md-6"><label class="form-label">Start Date</label><input type="date" name="start_date" class="form-control" required></div>
<div class="col-md-6"><label class="form-label">End Date</label><input type="date" name="end_date" class="form-control" required></div>
<div class="col-12"><label class="form-label">Reason</label><textarea name="reason" class="form-control" rows="3"></textarea></div>
</div>
<div class="mt-4"><button class="btn btn-primary">Submit</button> <a href="{{ route('leaves.index') }}" class="btn btn-light">Cancel</a></div></form></div>@endsection
