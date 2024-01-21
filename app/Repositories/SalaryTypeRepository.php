<?php

namespace App\Repositories;

use App\DTO\SalaryTypeDto;
use App\Models\SalaryType;
use Illuminate\Database\Eloquent\Collection;

final class SalaryTypeRepository
{
    public function findAll(): Collection
    {
        return SalaryType::query()->get();
    }

    public function findOneByType(int $type): ?SalaryType
    {
        /** @var SalaryType */
        return SalaryType::query()->where('type', $type)->first();
    }

    public function findOneByTitle(string $title): ?SalaryType
    {
        /** @var SalaryType */
        return SalaryType::query()->where('title', $title)->first();
    }

    public function create(SalaryTypeDto $salaryTypeDto): SalaryType
    {
        return SalaryType::query()->create($salaryTypeDto->toArray());
    }
}