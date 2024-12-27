<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;

class Promotion extends Model
{
    use HasTimestamps;

    protected $guarded = ['id', 'picture', 'created_at', 'updated_at'];
}
