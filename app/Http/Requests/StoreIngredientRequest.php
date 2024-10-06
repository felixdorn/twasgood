<?php

namespace App\Http\Requests;

use App\Enums\IngredientType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreIngredientRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:ingredients,name'],
            'type' => ['required', (new Enum(IngredientType::class))],
            'contains_gluten' => ['boolean'],
            'contains_dairy' => ['boolean'],
        ];
    }
}
