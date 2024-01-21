<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Repositories\DepartmentRepository;
use App\Repositories\PositionRepository;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        $departments = resolve(DepartmentRepository::class)->findAll();
        $positions   = resolve(PositionRepository::class)->findAll();

        for ($i = 0; $i < 500; $i++) {
            Employee::factory()
                ->create(
                    [
                        'first_name'    => fake()->firstName(),
                        'last_name'     => fake()->lastName(),
                        'patronymic'    => fake()->name(),
                        'birthdate'     => fake()->date,
                        'department_id' => $departments->random()->id,
                        'position_id'   => $positions->random()->id,
                        'salary_type'   => fake()->randomElement(array_keys(Employee::SALARY_TYPES_TITLES)),
                        'salary'        => round(fake()->randomFloat(2, 0.01, 999.99), 2),
                    ]
                );
        }
    }
}
