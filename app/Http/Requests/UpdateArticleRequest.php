<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateArticleRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['string', 'max:255'],
            'banner_alt' => ['string', 'max:255'],
            'description' => ['string', 'max:255'],
            'content' => ['json'],
        ];
    }
}
