<?php

namespace App\Http\Requests;

use App\Enums\IngredientType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateIngredientRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:ingredients,name,'.$this->route('ingredient')?->id],
            'type' => ['required', (new Enum(IngredientType::class))],
        ];
    }
}
