<?php

namespace App\Repositories;

use App\DTO\DepartmentDto;
use App\Exceptions\NotFoundException;
use App\Models\Department;
use Illuminate\Database\Eloquent\Collection;

final class DepartmentRepository
{
    public function findAll(): Collection
    {
        return Department::query()->get();
    }

    public function findOneByTitle(string $title, bool $throwException = false): ?Department
    {
        /** @var Department $department */
        $department = Department::query()->where('title', $title)->first();

        if (!$department && $throwException) {
            throw new NotFoundException("Department `{$title}` not found!");
        }

        return $department;
    }

    public function create(DepartmentDto $salaryTypeDto): Department
    {
        return Department::query()->create($salaryTypeDto->toArray());
    }
}