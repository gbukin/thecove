<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PromotionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'body' => 'required|string',
            'language' => 'required|string|max:2|in:en,ru,th',
            'picture' => 'nullable|file|image|mimes:jpg,jpeg,png,webp',
        ];
    }
}
