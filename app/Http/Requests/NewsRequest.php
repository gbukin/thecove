<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title_ru' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'announce_ru' => 'required|string',
            'announce_en' => 'required|string',
            'text_ru' => 'required|string',
            'text_en' => 'required|string',
            'show' => 'required|bool',
        ];
    }
}
