<?php

namespace App\Transformers;

use App\Models\News;
use Illuminate\Support\Collection;

class NewsTransformer
{
    /**
     * @param Collection<News> $news
     * @return array<int, array{
     *     id: non-negative-int,
     *     title_ru: string,
     *     title_en: string,
     *     created_at: string,
     *     updated_at: string|null
     * }>
    */
    public function transform(Collection $news): array
    {
        return $news->map(function (News $item) {
            return [
                'id' => $item->id,
                'title_ru' => $item->title_ru,
                'title_en' => $item->title_en,
//                'announce_ru' => $item->announce_ru,
//                'announce_en' => $item->announce_en,
//                'text_ru' => $item->text_ru,
//                'text_en' => $item->text_en,
                'created_at' => $item->created_at->format('d.m.y H:i'),
                'updated_at' => $item->updated_at?->format('d.m.y H:i'),
            ];
        })->toArray();
    }
}
