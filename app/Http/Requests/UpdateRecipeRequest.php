<?php

namespace App\Http\Requests;

use App\Enums\Season;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateRecipeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['string', 'max:255'],
            'description' => ['string', 'max:255'],
            'time_to_prepare' => ['nullable', 'string', 'max:255'],
            'season' => [new Enum(Season::class)],
            'content' => ['json'],
            'category_id' => ['exists:categories,id'],
            'uses_sterilization' => ['boolean'],
        ];
    }
}
