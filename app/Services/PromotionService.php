<?php

namespace App\Services;

use App\Models\Promotion;
use Illuminate\Http\UploadedFile;

class PromotionService
{
    const STORAGE_ROOT_PATH = 'promotions/';
    public static function saveFile(Promotion $promotion, UploadedFile $file): void
    {
        $filename = $promotion->id . '.' . $file->getClientOriginalExtension();

        $storage = \Storage::disk('public');

        if ($storage->exists(self::STORAGE_ROOT_PATH . $filename)) {
            $storage->delete(self::STORAGE_ROOT_PATH . $filename);
        }

        $storage->putFileAs(self::STORAGE_ROOT_PATH, $file, $filename);

        $promotion->picture = $filename;
        $promotion->save();
    }
}
