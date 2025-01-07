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
            $description = $request->get('description_' . $language);
            $body = $request->get('body_' . $language);

            if (empty($title) && empty($description) && empty($body)) {
                continue;
            }

            $errors = [];

            if (empty($title) || strlen($title) > 255) {
                $errors['title_' . $language] = '"Title ' . $language . '" empty or has more than 255 characters';
            }

            if (empty($description)) {
                $errors['description_' . $language] = '"Description ' . $language . '" is required';
            }

            if (empty($body)) {
                $errors['body_' . $language] = '"Body ' . $language . '" is required';
            }
        }

        if (!empty($errors)) {
            throw ValidationException::withMessages($errors);
        }
    }
}
