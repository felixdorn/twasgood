<?php

namespace App\Observers;

use App\Jobs\ComputeRecipeCategoriesJob;
use App\Models\Prerequisite;

class PrerequisiteObserver
{
    public function created(Prerequisite $prerequisite): void
    {
        // optimization: if the prerequisite was optional, we don't need to recompute the categories
        if ($prerequisite->optional) {
            return;
        }

        ComputeRecipeCategoriesJob::dispatch($prerequisite->recipe);
    }

    public function deleted(Prerequisite $prerequisite): void
    {
        // see comment above
        if ($prerequisite->optional) {
            return;
        }

        ComputeRecipeCategoriesJob::dispatch($prerequisite->recipe);
    }
}
