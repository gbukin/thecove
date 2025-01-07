<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\NewsRequest;

class News extends Model
{
    use HasTimestamps;

    protected $guarded = ['id', 'date', 'updated_at'];

    protected function casts(): array
    {
        return [
            'date' => 'datetime',
        ];
    }

    public function newsData(): HasMany
    {
        return $this->hasMany(NewsData::class);
    }

    /**
     * @throws ValidationException
    */
    public function validateData(NewsRequest $request): void
    {
        $languages = Language::getLanguagesNames();

        // Validation dynamic data
        foreach ($languages as $language) {
            $title = $request->get('title_' . $language);
            $announce = $request->get('announce_' . $language);
            $text = $request->get('text_' . $language);

            if (empty($title) && empty($announce) && empty($text)) {
                continue;
            }

            $errors = [];

            if (empty($title) || strlen($title) > 255) {
                $errors['title_' . $language] = '"Title ' . $language . '" empty or has more than 255 characters';
            }

            if (empty($announce)) {
                $errors['announce_' . $language] = '"Announce ' . $language . '" is required';
            }

            if (empty($text)) {
                $errors['text_' . $language] = '"Text ' . $language . '" is required';
            }
        }

        if (!empty($errors)) {
            throw ValidationException::withMessages($errors);
        }
    }
}
