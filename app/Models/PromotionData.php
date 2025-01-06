<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PromotionData extends Model
{
    use HasTimestamps;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }
}
