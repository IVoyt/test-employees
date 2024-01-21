<?php

namespace Database\Seeders;

use App\Models\EmployeeWorkHour;
use Illuminate\Database\Seeder;

class EmployeeWorkHourSeeder extends Seeder
{
    public function run(): void
    {
        EmployeeWorkHour::factory(10000)->create();
    }
}
