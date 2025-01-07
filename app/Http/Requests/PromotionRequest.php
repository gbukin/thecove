<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PromotionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'picture' => 'nullable|file|image|mimes:jpg,jpeg,png,webp',
            'start_at' => 'required|date|date_format:Y-m-d\TH:i:s.vp',
        ];
    }
}
