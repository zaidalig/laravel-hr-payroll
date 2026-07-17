<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $query = Attendance::with('employee');

        if ($request->filled('date')) {
            $query->whereDate('attendance_date', $request->input('date'));
        }

        if ($request->filled('employee_id')) {
            $query->where('employee_id', $request->input('employee_id'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        [$sort, $direction] = $this->tableSort($request, ['created_at', 'attendance_date', 'status'], 'created_at');
        $attendances = $query->orderBy($sort, $direction)->paginate($this->tablePerPage($request))->withQueryString();
        $employees = Employee::where('status', 'active')->orderBy('name')->get();

        return view('attendance.index', compact('attendances', 'employees'));
    }

    public function create()
    {
        $employees = Employee::where('status', 'active')->orderBy('name')->get();

        return view('attendance.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'attendance_date' => 'required|date',
            'status' => 'required|in:present,absent,late,half_day,leave',
            'check_in' => 'nullable',
            'check_out' => 'nullable',
            'notes' => 'nullable|string|max:255',
        ]);

        $exists = Attendance::where('employee_id', $data['employee_id'])
            ->whereDate('attendance_date', $data['attendance_date'])
            ->exists();

        if ($exists) {
            return back()->with('error', 'Attendance already marked for this employee on this date.')->withInput();
        }

        Attendance::create($data);

        return redirect()->route('attendance.index')->with('success', 'Attendance recorded.');
    }

    public function edit(Attendance $attendance)
    {
        $employees = Employee::where('status', 'active')->orderBy('name')->get();

        return view('attendance.edit', compact('attendance', 'employees'));
    }

    public function update(Request $request, Attendance $attendance)
    {
        $data = $request->validate([
            'status' => 'required|in:present,absent,late,half_day,leave',
            'check_in' => 'nullable',
            'check_out' => 'nullable',
            'notes' => 'nullable|string|max:255',
        ]);
        $attendance->update($data);

        return redirect()->route('attendance.index')->with('success', 'Attendance updated.');
    }

    public function destroy(Attendance $attendance)
    {
        $attendance->delete();

        return redirect()->route('attendance.index')->with('success', 'Attendance deleted.');
    }
}
