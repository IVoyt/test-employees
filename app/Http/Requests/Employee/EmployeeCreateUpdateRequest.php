<?php

namespace App\Http\Requests\Employee;

use App\Models\Department;
use App\Models\Position;
use App\Models\SalaryType;
use Illuminate\Contracts\Validation\ValidationRule;
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
            'first_name'     => ['required', 'string'],
            'last_name'      => ['required', 'string'],
            'patronymic'     => ['string'],
            'birthdate'      => ['required', 'string', 'date'],
            'department_id'  => ['required', 'integer', Rule::exists(Department::class, 'id')],
            'position_id'    => ['required', 'integer', Rule::exists(Position::class, 'id')],
            'salary_type_id' => ['required', 'integer', Rule::exists(SalaryType::class, 'id')],
            'salary'         => ['required', 'numeric']
        ];
    }
}
