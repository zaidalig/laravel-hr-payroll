@extends('layouts.app')@section('title','Mark Attendance')@section('page_title','Mark Attendance')
@section('content')<div class="card p-4 border-0 shadow-sm"><form method="POST" action="{{ route('attendance.store') }}">@csrf
<div class="row g-3">
<div class="col-md-6"><label class="form-label">Employee</label><select name="employee_id" class="form-select" required>@foreach($employees as $e)<option value="{{ $e->id }}">{{ $e->name }} ({{ $e->employee_code }})</option>@endforeach</select></div>
<div class="col-md-6"><label class="form-label">Date</label><input type="date" name="attendance_date" class="form-control" value="{{ date('Y-m-d') }}" required></div>
<div class="col-md-4"><label class="form-label">Status</label><select name="status" class="form-select">@foreach(['present','absent','late','half_day','leave'] as $s)<option value="{{ $s }}">{{ ucfirst(str_replace('_',' ',$s)) }}</option>@endforeach</select></div>
<div class="col-md-4"><label class="form-label">Check In</label><input type="time" name="check_in" class="form-control"></div>
<div class="col-md-4"><label class="form-label">Check Out</label><input type="time" name="check_out" class="form-control"></div>
<div class="col-12"><label class="form-label">Notes</label><input name="notes" class="form-control"></div>
</div>
<div class="mt-4"><button class="btn btn-primary">Save</button> <a href="{{ route('attendance.index') }}" class="btn btn-light">Cancel</a></div></form></div>@endsection
