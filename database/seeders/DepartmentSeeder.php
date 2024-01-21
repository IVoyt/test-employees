<?php

namespace Database\Seeders;

use App\DTO\DepartmentDto;
use App\Repositories\DepartmentRepository;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $departmentTitles = [
            'it',
            'sales',
            'hr',
            'accounting'
        ];

        $departmentRepository = resolve(DepartmentRepository::class);

        foreach ($departmentTitles as $title) {
            if ($departmentRepository->findOneByTitle($title)) {
                continue;
            }

            $departmentRepository->create(
                new DepartmentDto($title)
            );
        }
    }
}
