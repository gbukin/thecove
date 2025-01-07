<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\PromotionRequest;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Promotion extends Model
{
    use HasTimestamps;

    protected $guarded = ['id', 'picture', 'created_at', 'updated_at'];

    public function promotionData(): HasMany
    {
        return $this->hasMany(PromotionData::class);
    }

    /**
     * @throws ValidationException
     */
    public function validateData(PromotionRequest $request): void
    {
        $languages = Language::getLanguagesNames();

        // Validation dynamic data
        foreach ($languages as $language) {
            $title = $request->get('title_' . $language);
            $announce = $request->get('description_' . $language);
            $text = $request->get('body_' . $language);

            $errors = [];

            if (empty($title) || strlen($title) > 255) {
                $errors['title_' . $language] = 'title_' . $language . ' empty or has more than 255 characters';
            }

            if (empty($announce)) {
                $errors['announce_' . $language] = 'description_' . $language . ' is required';
            }

            if (empty($text)) {
                $errors['text_' . $language] = 'body_' . $language . ' is required';
            }
        }

        if (!empty($errors)) {
            throw ValidationException::withMessages($errors);
        }
    }
}
