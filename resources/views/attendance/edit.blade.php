@extends('layouts.app')@section('title','Edit Attendance')@section('page_title','Edit Attendance')
@section('content')<div class="card p-4 border-0 shadow-sm">
<p class="text-muted">{{ $attendance->employee->name }} — {{ $attendance->attendance_date->format('M d, Y') }}</p>
<form method="POST" action="{{ route('attendance.update',$attendance) }}">@csrf @method('PUT')
<div class="row g-3">
<div class="col-md-4"><label class="form-label">Status</label><select name="status" class="form-select">@foreach(['present','absent','late','half_day','leave'] as $s)<option value="{{ $s }}" @selected($attendance->status===$s)>{{ ucfirst(str_replace('_',' ',$s)) }}</option>@endforeach</select></div>
<div class="col-md-4"><label class="form-label">Check In</label><input type="time" name="check_in" class="form-control" value="{{ $attendance->check_in }}"></div>
<div class="col-md-4"><label class="form-label">Check Out</label><input type="time" name="check_out" class="form-control" value="{{ $attendance->check_out }}"></div>
<div class="col-12"><label class="form-label">Notes</label><input name="notes" class="form-control" value="{{ $attendance->notes }}"></div>
</div>
<div class="mt-4"><button class="btn btn-primary">Update</button> <a href="{{ route('attendance.index') }}" class="btn btn-light">Cancel</a></div></form></div>@endsection
