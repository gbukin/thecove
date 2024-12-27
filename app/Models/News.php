<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;

class News extends Model
{
    use HasTimestamps;

    protected $guarded = ['id', 'created_at', 'updated_at'];
}
