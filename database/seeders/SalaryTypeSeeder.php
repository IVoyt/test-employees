<?php

namespace Database\Seeders;

use App\DTO\SalaryTypeDto;
use App\Models\SalaryType;
use App\Repositories\SalaryTypeRepository;
use Illuminate\Database\Seeder;

class SalaryTypeSeeder extends Seeder
{
    public function run(): void
    {
        $salaryTypeRepository = resolve(SalaryTypeRepository::class);

        foreach (SalaryType::TYPES_TITLES as $type => $title) {
            if ($salaryTypeRepository->findOneByType($type)) {
                continue;
            }

            $salaryTypeRepository->create(
                new SalaryTypeDto($type, $title)
            );
        }
    }
}
