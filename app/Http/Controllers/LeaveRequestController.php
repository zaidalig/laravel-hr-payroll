<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;

class LeaveRequestController extends Controller
{
    public function index(Request $request)
    {
        $query = LeaveRequest::with(['employee', 'reviewer']);

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('employee_id')) {
            $query->where('employee_id', $request->input('employee_id'));
        }

        [$sort, $direction] = $this->tableSort($request, ['created_at', 'start_date', 'status']);
        $leaves = $query->orderBy($sort, $direction)->paginate($this->tablePerPage($request))->withQueryString();
        $employees = Employee::where('status', 'active')->orderBy('name')->get();

        return view('leaves.index', compact('leaves', 'employees'));
    }

    public function create()
    {
        $employees = Employee::where('status', 'active')->orderBy('name')->get();

        return view('leaves.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'type' => 'required|in:casual,sick,annual,unpaid',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'nullable|string',
        ]);
        $data['status'] = 'pending';
        LeaveRequest::create($data);

        return redirect()->route('leaves.index')->with('success', 'Leave request submitted.');
    }

    public function updateStatus(Request $request, LeaveRequest $leave)
    {
        $data = $request->validate([
            'status' => 'required|in:approved,rejected',
        ]);

        $leave->update($data + ['reviewed_by' => auth()->id()]);

        return back()->with('success', "Leave request {$data['status']}.");
    }

    public function destroy(LeaveRequest $leave)
    {
        $leave->delete();

        return redirect()->route('leaves.index')->with('success', 'Leave request deleted.');
    }
}
