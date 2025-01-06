<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $guarded = ['id', 'created_at'];

    /**
     * @return string[]
    */
    public static function getLanguagesNames(): array
    {
        return self::all()->pluck('name')->toArray();
    }
}
