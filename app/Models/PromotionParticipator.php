<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;

class PromotionParticipator extends Model
{
    use HasTimestamps;

    public const UPDATED_AT = null;

    protected function casts(): array
    {
        return [
            'check_time' => 'datetime:d.m.Y H:i',
        ];
    }
}
