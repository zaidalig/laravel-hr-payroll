<div class="row g-3">
<div class="col-md-3"><label class="form-label">Employee Code</label><input name="employee_code" class="form-control" value="{{ old('employee_code', $employee->employee_code ?? '') }}" required></div>
<div class="col-md-5"><label class="form-label">Full Name</label><input name="name" class="form-control" value="{{ old('name', $employee->name ?? '') }}" required></div>
<div class="col-md-4"><label class="form-label">Department</label><select name="department_id" class="form-select"><option value="">None</option>@foreach($departments as $d)<option value="{{ $d->id }}" @selected(old('department_id', $employee->department_id ?? '')==$d->id)>{{ $d->name }}</option>@endforeach</select></div>
<div class="col-md-4"><label class="form-label">Email</label><input type="email" name="email" class="form-control" value="{{ old('email', $employee->email ?? '') }}"></div>
<div class="col-md-4"><label class="form-label">Phone</label><input name="phone" class="form-control" value="{{ old('phone', $employee->phone ?? '') }}"></div>
<div class="col-md-4"><label class="form-label">Designation</label><input name="designation" class="form-control" value="{{ old('designation', $employee->designation ?? '') }}" required></div>
<div class="col-md-4"><label class="form-label">Base Salary</label><input type="number" step="0.01" name="base_salary" class="form-control" value="{{ old('base_salary', $employee->base_salary ?? 0) }}" required></div>
<div class="col-md-4"><label class="form-label">Joined At</label><input type="date" name="joined_at" class="form-control" value="{{ old('joined_at', isset($employee) ? $employee->joined_at->format('Y-m-d') : date('Y-m-d')) }}" required></div>
<div class="col-md-4"><label class="form-label">Status</label><select name="status" class="form-select">@foreach(['active','inactive','terminated'] as $s)<option value="{{ $s }}" @selected(old('status', $employee->status ?? 'active')===$s)>{{ ucfirst($s) }}</option>@endforeach</select></div>
</div>
