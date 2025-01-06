<?php

namespace App\Transformers;

use Illuminate\Support\Collection;
use App\Models\Language;

class LanguageTransformer
{
    /**
     * @param Collection<Language> $news
     * @return array<int, array{
     *     id: non-negative-int,
     *     name: string,
     *     created_at: string,
     *     updated_at: string|null
     * }>
    */
    public function transform(Collection $news): array
    {
        return $news->map(function (Language $item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
                'created_at' => $item->created_at->format('d.m.Y H:i'),
            ];
        })->toArray();
    }
}
