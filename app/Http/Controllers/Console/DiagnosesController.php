<?php

namespace App\Http\Controllers\Console;

use App\Enums\DiagnosisType;
use App\Models\Diagnosis;
use App\Models\Tag;

class DiagnosesController
{
    public function index()
    {
        return inertia('Console/Diagnoses/Index', [
            'diagnoses' => Diagnosis::query()
                ->where('type', '<>', DiagnosisType::BadAssetAlt->value)
                ->with([
                    'recipe' => fn ($query) => $query->select('id', 'title')->with(['tags', 'illustrations', 'banner']),
                ])
                ->latest()->where('resolved_at', null)->get(),

            'typeTags' => Tag::recipeTypeGroup()->children()->get(['id', 'name']),
            'seasonTags' => Tag::seasonGroup()->children()->get(['id', 'name']),
            'hotColdTags' => Tag::hotColdGroup()->children()->get(['id', 'name']),
        ]);
    }

    public function complete(Diagnosis $diagnosis)
    {
        $diagnosis->update([
            'resolved_at' => now(),
        ]);

        return back();
    }
}
