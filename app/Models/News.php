<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;

class News extends Model
{
    use HasTimestamps;

    public const CREATED_AT = 'date';

    protected $guarded = ['id', 'date', 'updated_at'];

    protected function casts(): array
    {
        return [
            'date' => 'datetime',
        ];
    }
}
