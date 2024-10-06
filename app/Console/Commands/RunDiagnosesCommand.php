<?php

namespace App\Console\Commands;

use App\Models\Asset;
use App\Models\Recipe;
use Illuminate\Console\Command;
use Throwable;

class RunDiagnosesCommand extends Command
{
    protected $signature = 'diagnoses:run';

    protected $description = 'Run diagnoses';

    public function handle(): void
    {
        Asset::all()->each(function (Asset $asset) {
            $this->components->task($asset->path, fn () => $asset->diagnose());
        });

        $recipes = Recipe::with('tags', 'diagnoses', 'assets', 'category')->get()->all();

        foreach ($recipes as $recipe) {
            try {
                $this->components->task("{$recipe->title}", fn () => $recipe->diagnose());
            } catch (Throwable $e) {
                report($e);
                throw $e;
                $this->components->task("{$recipe->title}", fn () => false);
            }
        }

    }
}
