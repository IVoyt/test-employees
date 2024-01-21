<?php

namespace Database\Seeders;

use App\Models\EmployeeWorkHour;
use App\Repositories\EmployeeRepository;
use Illuminate\Database\Seeder;

class EmployeeWorkHourSeeder extends Seeder
{
    public function run(): void
    {
        $employees = resolve(EmployeeRepository::class)->findAll();
        
        for ($i = 0; $i < 10000; $i++) {
            $date = fake()->dateTimeBetween('first day of this month', 'last day of this month');
            EmployeeWorkHour::query()->create(
                [
                    'employee_id' => $employees->random()->id,
                    'hours'       => fake()->randomDigitNotZero(),
                    'created_at'  => $date,
                    'updated_at'  => $date,
                ]
            );
        }
    }
}
