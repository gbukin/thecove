<?php

namespace App\Transformers;

use Illuminate\Support\Collection;
use App\Models\Promotion;

class PromotionsTransformer
{
    /**
     * @param Collection<Promotion> $news
     * @return array<int, array{
     *     id: int,
     *     title_ru: string,
     *     title_en: string,
     *     picture: string|null,
     *     created_at: string,
     *     updated_at: string|null
     * }>
    */
    public function transform(Collection $news): array
    {
        return $news->map(function (Promotion $item) {
            return [
                'id' => $item->id,
                'title_ru' => $item->promotionData()->Ru()->first()?->title ?? '',
                'title_en' => $item->promotionData()->En()->first()?->title ?? '',
                'picture' => $item->picture,
                'created_at' => $item->created_at->format('d.m.Y H:i'),
                'updated_at' => $item->updated_at?->format('d.m.Y H:i'),
            ];
        })->toArray();
    }
}
