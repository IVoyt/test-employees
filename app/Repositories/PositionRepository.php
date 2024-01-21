<?php

namespace App\Repositories;

use App\Models\Position;
use Illuminate\Database\Eloquent\Collection;

final class PositionRepository
{
    public function findAll(): Collection
    {
        return Position::query()->get();
    }

    public function findOneByTitle(string $title): ?Position
    {
        return Position::query()->where('title', $title)->first();
    }
}