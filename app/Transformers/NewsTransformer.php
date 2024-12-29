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
     *     date: string,
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
                'show' => $item->show,
                'date' => $item->date->format('d.m.Y H:i'),
                'updated_at' => $item->updated_at?->format('d.m.Y H:i'),
            ];
        })->toArray();
    }
}
