<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Payroll;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    public function index(Request $request)
    {
        $query = Payroll::with('employee');

        if ($request->filled('period')) {
            $query->where('period', $request->input('period'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        [$sort, $direction] = $this->tableSort($request, ['created_at', 'period', 'net_salary', 'status']);
        $payrolls = $query->orderBy($sort, $direction)->paginate($this->tablePerPage($request))->withQueryString();

        return view('payroll.index', compact('payrolls'));
    }

    public function create()
    {
        $employees = Employee::where('status', 'active')->orderBy('name')->get();

        return view('payroll.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'period' => 'required|string|max:7',
            'allowances' => 'nullable|numeric|min:0',
            'deductions' => 'nullable|numeric|min:0',
        ]);

        $exists = Payroll::where('employee_id', $data['employee_id'])
            ->where('period', $data['period'])
            ->exists();

        if ($exists) {
            return back()->with('error', 'Payroll already generated for this employee and period.')->withInput();
        }

        $employee = Employee::findOrFail($data['employee_id']);
        $allowances = $data['allowances'] ?? 0;
        $deductions = $data['deductions'] ?? 0;

        Payroll::create([
            'employee_id' => $employee->id,
            'period' => $data['period'],
            'base_salary' => $employee->base_salary,
            'allowances' => $allowances,
            'deductions' => $deductions,
            'net_salary' => $employee->base_salary + $allowances - $deductions,
            'status' => 'pending',
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('payroll.index')->with('success', 'Payroll generated.');
    }

    public function show(Payroll $payroll)
    {
        $payroll->load(['employee.department', 'user']);

        return view('payroll.show', compact('payroll'));
    }

    public function print(Payroll $payroll)
    {
        $payroll->load(['employee.department', 'user']);

        return view('payroll.print', compact('payroll'));
    }

    public function markPaid(Payroll $payroll)
    {
        if ($payroll->status === 'paid') {
            return back()->with('error', 'Payroll is already paid.');
        }

        $payroll->update(['status' => 'paid', 'paid_at' => today()]);

        return back()->with('success', 'Payroll marked as paid.');
    }

    public function destroy(Payroll $payroll)
    {
        if ($payroll->status === 'paid') {
            return back()->with('error', 'Cannot delete a paid payroll.');
        }

        $payroll->delete();

        return redirect()->route('payroll.index')->with('success', 'Payroll deleted.');
    }
}
