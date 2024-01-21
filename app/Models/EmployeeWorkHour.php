<?php

namespace App\Models;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int    $id
 * @property int    $employee_id
 * @property int    $hours
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @mixin Eloquent
 */
class EmployeeWorkHour extends Model
{
    protected $fillable = [
        'employee_id',
        'hours'
    ];

    protected $casts = [
        'created_at' => 'date',
        'updated_at' => 'date',
    ];

    public function scopeThisMonth(Builder $query): void
    {
        $query->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()]);
    }
}
