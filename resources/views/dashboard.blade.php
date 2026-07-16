@extends('layouts.app')
@section('title','Dashboard')@section('page_title','HR Dashboard')
@section('content')
<div class="row g-4 mb-4">
@foreach([['Employees',$stats['employees'],'id-badge','primary'],['Departments',$stats['departments'],'building-user','info'],['Present Today',$stats['present_today'],'calendar-check','success'],['Pending Leaves',$stats['pending_leaves'],'umbrella-beach','warning'],['Pending Payrolls',$stats['pending_payrolls'],'money-check-dollar','danger']] as $s)
<div class="col-md-4 col-xl"><div class="card stat-card card-{{ $s[3] }} p-3"><div class="d-flex justify-content-between"><div><div class="text-muted small">{{ $s[0] }}</div><h3 class="fw-bold mb-0">{{ $s[1] }}</h3></div><div class="card-icon bg-{{ $s[3] }}-subtle text-{{ $s[3] }}"><i class="fa-solid fa-{{ $s[2] }}"></i></div></div></div></div>
@endforeach
</div>
<div class="row g-4">
<div class="col-lg-6"><div class="card card-table border-0"><div class="card-header bg-white fw-bold">Pending Leave Requests</div><div class="table-responsive"><table class="table mb-0"><thead class="table-light"><tr><th>Employee</th><th>Type</th><th>From</th><th>To</th></tr></thead><tbody>@forelse($pendingLeaves as $l)<tr><td>{{ $l->employee->name }}</td><td>{{ ucfirst($l->type) }}</td><td>{{ $l->start_date->format('M d') }}</td><td>{{ $l->end_date->format('M d') }}</td></tr>@empty<tr><td colspan="4" class="text-center py-3 text-muted">No pending leaves.</td></tr>@endforelse</tbody></table></div></div></div>
<div class="col-lg-6"><div class="card card-table border-0"><div class="card-header bg-white fw-bold">Recent Payrolls</div><div class="table-responsive"><table class="table mb-0"><thead class="table-light"><tr><th>Employee</th><th>Period</th><th>Net</th><th>Status</th></tr></thead><tbody>@forelse($recentPayrolls as $p)<tr><td>{{ $p->employee->name }}</td><td>{{ $p->period }}</td><td>${{ number_format($p->net_salary,2) }}</td><td>{{ ucfirst($p->status) }}</td></tr>@empty<tr><td colspan="4" class="text-center py-3 text-muted">No payrolls yet.</td></tr>@endforelse</tbody></table></div></div></div>
</div>
<div class="card card-table border-0 mt-4"><div class="card-header bg-white fw-bold">Latest Activity</div><div class="table-responsive"><table class="table mb-0"><thead class="table-light"><tr><th>Action</th><th>Description</th><th>User</th><th>When</th></tr></thead><tbody>@foreach($recentLogs as $log)<tr><td><span class="badge bg-light text-dark border">{{ $log->action }}</span></td><td>{{ $log->description }}</td><td>{{ $log->user?->name ?? 'System' }}</td><td class="text-muted small">{{ $log->created_at->diffForHumans() }}</td></tr>@endforeach</tbody></table></div></div>
@endsection
