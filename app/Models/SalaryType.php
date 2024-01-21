<?php

namespace App\Models;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int    $id
 * @property int    $type
 * @property string $title
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @mixin Eloquent
 */
class SalaryType extends Model
{
    public const int   TYPE_HOURLY  = 1;
    public const int   TYPE_MONTHLY = 2;
    public const array TYPES_TITLES = [
        self::TYPE_HOURLY  => 'hourly',
        self::TYPE_MONTHLY => 'monthly'
    ];

    protected $fillable = [
        'title',
        'type'
    ];

    protected $casts = [
        'created_at' => 'date',
        'updated_at' => 'date',
    ];
}
