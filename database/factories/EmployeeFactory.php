<?php

namespace Database\Factories;

use App\Repositories\DepartmentRepository;
use App\Repositories\PositionRepository;
use App\Repositories\SalaryTypeRepository;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    public function definition(): array
    {
        $departmentRepository = resolve(DepartmentRepository::class);
        $positionRepository   = resolve(PositionRepository::class);
        $salaryTypeRepository = resolve(SalaryTypeRepository::class);
        $departments          = $departmentRepository->findAll();
        $positions            = $positionRepository->findAll();
        $salaryTypes          = $salaryTypeRepository->findAll();

        return [
            'first_name'     => fake()->firstName(),
            'last_name'      => fake()->lastName(),
            'patronymic'     => fake()->name(),
            'birthdate'      => fake()->date,
            'department_id'  => $departments->random()->id,
            'position_id'    => $positions->random()->id,
            'salary_type_id' => $salaryTypes->random()->id,
            'salary'         => fake()->randomFloat(2, 0.01, 999.99),
        ];
    }
}
