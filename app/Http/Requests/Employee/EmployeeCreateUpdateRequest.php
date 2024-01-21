<?php

namespace App\Http\Requests\Employee;

use App\Models\Department;
use App\Models\Employee;
use App\Models\Position;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EmployeeCreateUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name'    => ['required', 'string'],
            'last_name'     => ['required', 'string'],
            'patronymic'    => ['string'],
            'birthdate'     => ['required', 'string', 'date'],
            'department_id' => ['sometimes', 'integer', Rule::exists(Department::class, 'id')],
            'position_id'   => ['sometimes', 'integer', Rule::exists(Position::class, 'id')],
            'salary_type'   => ['required', 'integer', Rule::in(array_keys(Employee::SALARY_TYPES_TITLES))],
            'salary'        => ['required', 'numeric', 'min:0.01', 'max:999.99']
        ];
    }
}
