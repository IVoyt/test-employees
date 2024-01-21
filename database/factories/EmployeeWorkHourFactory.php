<?php

namespace Database\Factories;

use App\Repositories\EmployeeRepository;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeWorkHourFactory extends Factory
{
    public function definition(): array
    {
        $employeeRepository = resolve(EmployeeRepository::class);

        $date = fake()->dateTimeBetween('first day of this month', 'last day of this month');

        return [
            'employee_id' => $employeeRepository->findAll()->random()->id,
            'hours'       => fake()->randomDigitNotZero(),
            'created_at'  => $date,
            'updated_at'  => $date,
        ];
    }
}
