<?php

namespace App\Transformers;

use Illuminate\Support\Collection;
use App\Models\PromotionParticipator;

class PromotionParticipatorsTransformer
{
    /**
     * @param Collection<PromotionParticipator> $news
     * @return array<int, array{
     *     id: int,
     *     full_name: string,
     *     phone: string,
     *     check_number: string,
     *     check_sum: string,
     *     check_time: string,
     *     created_at: string,
     * }>
    */
    public function transform(Collection $news): array
    {
        return $news->map(function (PromotionParticipator $item) {
            return [
                'id' => $item->id,
                'full_name' => $item->full_name,
                'phone' => $item->phone,
                'check_number' => $item->check_number,
                'check_sum' => $item->check_sum,
                'check_time' => $item->check_time?->format('d.m.Y H:i'),
                'created_at' => $item->created_at?->format('d.m.Y H:i'),
            ];
        })->toArray();
    }
}
