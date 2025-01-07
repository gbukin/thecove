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
     *     show: bool,
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
                'show' => $item->show,
                'title_ru' => $item->newsData()->Ru()->first()?->title ?? '',
                'title_en' => $item->newsData()->En()->first()?->title ?? '',
                'created_at' => $item->created_at->format('d.m.Y H:i'),
                'updated_at' => $item->updated_at?->format('d.m.Y H:i'),
            ];
        })->toArray();
    }
}
