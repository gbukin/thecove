<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\LanguageAvailable;

class NewsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'show' => 'required|bool',
        ];
    }
}
