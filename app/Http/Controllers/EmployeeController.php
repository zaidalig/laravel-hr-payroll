<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeRequest;
use App\Models\Department;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $query = Employee::with('department');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('employee_code', 'like', "%{$search}%")
                    ->orWhere('designation', 'like', "%{$search}%");
            });
        }

        if ($request->filled('department_id')) {
            $query->where('department_id', $request->input('department_id'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $employees = $query->latest()->paginate(10)->withQueryString();
        $departments = Department::where('status', 'active')->orderBy('name')->get();

        return view('employees.index', compact('employees', 'departments'));
    }

    public function create()
    {
        $departments = Department::where('status', 'active')->orderBy('name')->get();

        return view('employees.create', compact('departments'));
    }

    public function store(EmployeeRequest $request)
    {
        $employee = Employee::create($request->validated());

        return redirect()->route('employees.index')
            ->with('success', "Employee \"{$employee->name}\" created.");
    }

    public function show(Employee $employee)
    {
        $employee->load([
            'department',
            'attendances' => fn ($q) => $q->latest('attendance_date')->limit(10),
            'leaveRequests' => fn ($q) => $q->latest()->limit(5),
            'payrolls' => fn ($q) => $q->latest()->limit(6),
        ]);

        return view('employees.show', compact('employee'));
    }

    public function edit(Employee $employee)
    {
        $departments = Department::where('status', 'active')->orderBy('name')->get();

        return view('employees.edit', compact('employee', 'departments'));
    }

    public function update(EmployeeRequest $request, Employee $employee)
    {
        $employee->update($request->validated());

        return redirect()->route('employees.show', $employee)
            ->with('success', "Employee \"{$employee->name}\" updated.");
    }

    public function destroy(Employee $employee)
    {
        $name = $employee->name;
        $employee->delete();

        return redirect()->route('employees.index')
            ->with('success', "Employee \"{$name}\" deleted.");
    }
}
