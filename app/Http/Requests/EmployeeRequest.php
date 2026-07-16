<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EmployeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $employeeId = $this->route('employee')?->id;

        return [
            'department_id' => 'nullable|exists:departments,id',
            'employee_code' => ['required', 'string', 'max:20', Rule::unique('employees')->ignore($employeeId)],
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:50',
            'designation' => 'required|string|max:100',
            'base_salary' => 'required|numeric|min:0',
            'joined_at' => 'required|date',
            'status' => 'required|in:active,inactive,terminated',
        ];
    }
}
