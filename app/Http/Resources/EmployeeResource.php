<?php

namespace App\Http\Resources;

use App\Models\Employee;
use App\Models\EmployeeWorkHour;
use App\Models\SalaryType;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Employee */
class EmployeeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $hours = $this->workHoursThisMonth->sum(function (EmployeeWorkHour $employeeWorkHour) {
            return $employeeWorkHour->hours;
        });
        return [
            'id'          => $this->id,
            'first_name'  => $this->first_name,
            'last_name'   => $this->last_name,
            'patronymic'  => $this->patronymic,
            'birthdate'   => $this->birthdate,
            'department'  => $this->department->title ?? null,
            'position'    => $this->position->title ?? null,
            'salary_type' => Employee::SALARY_TYPES_TITLES[$this->salary_type],
            'salary'      => $this->salary_type === Employee::SALARY_TYPE_MONTHLY
                ? round($this->salary, 2)
                : round($hours * $this->salary, 2),
            'created_at'  => $this->created_at,
            'updated_at'  => $this->updated_at
        ];
    }
}
