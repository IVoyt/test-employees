<?php

namespace App\Models;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int    $id
 * @property string $title
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @mixin Eloquent
 */
class Position extends Model
{
    use HasFactory;

    protected $fillable = [
        'title'
    ];

    protected $casts = [
        'created_at' => 'date',
        'updated_at' => 'date',
    ];
}
