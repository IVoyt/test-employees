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
            'department'  => $this->department->title,
            'position'    => $this->position->title,
            'salary_type' => $this->salaryType->title,
            'salary'      => $this->salaryType->type === SalaryType::TYPE_MONTHLY
                ? $this->salary
                : $hours * $this->salary,
            'created_at'  => $this->created_at,
            'updated_at'  => $this->updated_at
        ];
    }
}
