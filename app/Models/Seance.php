<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 * @mixin Builder
 */
class Seance extends Model
{
    use HasFactory;

    protected $table = 'seances';

    protected $fillable = [
        'startTime',
        'filmId',
        'hallId',
    ];
}

