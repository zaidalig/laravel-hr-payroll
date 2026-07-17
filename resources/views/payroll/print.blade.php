<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Payslip — {{ $payroll->period }}</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
@media print { .no-print { display: none !important; } }
body { background: #f8f9fa; }
.payslip { max-width: 640px; margin: 2rem auto; background: #fff; border: 1px solid #dee2e6; border-radius: .5rem; padding: 2rem; }
</style>
</head>
<body>
<div class="payslip">
<div class="text-center mb-4"><h3 class="fw-bold mb-1">Payslip</h3><p class="text-muted mb-0">{{ $payroll->period }}</p></div>
<div class="d-flex justify-content-between mb-3">
<div><h4 class="fw-bold mb-0">{{ $payroll->employee->name }}</h4><span class="text-muted">{{ $payroll->employee->employee_code }} | {{ $payroll->employee->department?->name ?? '-' }}</span></div>
<span class="badge {{ $payroll->status==='paid'?'bg-success-subtle text-success':'bg-warning-subtle text-warning' }} align-self-start px-3 py-2">{{ ucfirst($payroll->status) }}</span>
</div>
<table class="table">
<tr><td>Period</td><td class="text-end">{{ $payroll->period }}</td></tr>
<tr><td>Base Salary</td><td class="text-end">${{ number_format($payroll->base_salary,2) }}</td></tr>
<tr><td>Allowances</td><td class="text-end text-success">+ ${{ number_format($payroll->allowances,2) }}</td></tr>
<tr><td>Deductions</td><td class="text-end text-danger">− ${{ number_format($payroll->deductions,2) }}</td></tr>
<tr class="fw-bold"><td>Net Salary</td><td class="text-end">${{ number_format($payroll->net_salary,2) }}</td></tr>
@if($payroll->paid_at)<tr><td>Paid On</td><td class="text-end">{{ $payroll->paid_at->format('M d, Y') }}</td></tr>@endif
</table>
<div class="no-print text-center mt-3"><button onclick="window.print()" class="btn btn-primary"><i class="fa-solid fa-print"></i> Print</button> <button onclick="window.close()" class="btn btn-light">Close</button></div>
</div>
<script>window.addEventListener('load', function(){ window.print(); });</script>
</body>
</html>
