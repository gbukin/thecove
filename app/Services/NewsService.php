<?php

namespace App\Services;

use App\Models\Promotion;
use Illuminate\Http\UploadedFile;
use App\Models\News;

class NewsService
{
    const STORAGE_ROOT_PATH = 'news/';
    public static function saveFile(News $news, UploadedFile $file): void
    {
        $filename = $news->id . '.' . $file->getClientOriginalExtension();

        $storage = \Storage::disk('public');

        if ($storage->exists(self::STORAGE_ROOT_PATH . $filename)) {
            $storage->delete(self::STORAGE_ROOT_PATH . $filename);
        }

        $storage->putFileAs(self::STORAGE_ROOT_PATH, $file, $filename);

        $news->picture ='/storage/' . self::STORAGE_ROOT_PATH . $filename;
        $news->save();
    }
}
