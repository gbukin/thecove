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
     *     title: string,
     *     description: string,
     *     body: string,
     *     language: string,
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
                'title' => $item->title,
                'description' => $item->description,
                'language' => $item->language,
                'picture' => asset('storage/promotions/' . $item->picture),
                'created_at' => $item->created_at->format('d.m.y H:i'),
                'updated_at' => $item->updated_at?->format('d.m.y H:i'),
            ];
        })->toArray();
    }
}
