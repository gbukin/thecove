<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'picture' => 'nullable|file|image|mimes:jpg,jpeg,png,webp',
            'show' => 'required|bool',
        ];
    }
}
