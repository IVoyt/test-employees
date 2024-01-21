<?php

namespace App\Models;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int                                $id
 * @property string                             $first_name
 * @property string                             $last_name
 * @property string                             $patronymic
 * @property Carbon                             $birthdate
 * @property int                                $department_id
 * @property int                                $position_id
 * @property int                                $salary_type
 * @property float                              $salary
 * @property Carbon                             $created_at
 * @property Carbon                             $updated_at
 *
 * @property-read Department                    $department
 * @property-read Position                      $position
 * @property-read Collection|EmployeeWorkHour[] $workHoursThisMonth
 *
 * @mixin Eloquent
 */
class Employee extends Model
{
    use HasFactory;

    public const int   SALARY_TYPE_HOURLY  = 1;
    public const int   SALARY_TYPE_MONTHLY = 2;
    public const array SALARY_TYPES_TITLES = [
        self::SALARY_TYPE_HOURLY  => 'hourly',
        self::SALARY_TYPE_MONTHLY => 'monthly'
    ];

    protected $fillable = [
        'first_name',
        'last_name',
        'patronymic',
        'birthdate',
        'department_id',
        'position_id',
        'salary_type',
        'salary',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'salary'     => 'float',
        'birthdate'  => 'date',
        'created_at' => 'date',
        'updated_at' => 'date',
    ];

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class);
    }

    public function workHoursThisMonth(): HasMany
    {
        return $this->hasMany(EmployeeWorkHour::class)->thisMonth();
    }
}
