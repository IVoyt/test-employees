<?php

namespace Database\Factories;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'first_name'  => fake()->firstName(),
            'last_name'   => fake()->lastName(),
            'patronymic'  => fake()->name(),
            'birthdate'   => fake()->date,
            'salary_type' => fake()->randomElement(array_keys(Employee::SALARY_TYPES_TITLES)),
            'salary'      => fake()->randomFloat(2, 0.01, 999.99),
        ];
    }
}
