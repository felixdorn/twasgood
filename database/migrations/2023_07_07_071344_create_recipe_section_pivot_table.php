<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRecipeSectionPivotTable extends Migration
{
    public function up(): void
    {
        Schema::create('recipe_section', function (Blueprint $table) {
            $table->foreignId('recipe_id')->references('id')->on('recipes')->cascadeOnDelete();
            $table->foreignId('section_id')->references('id')->on('sections')->cascadeOnDelete();

            $table->primary(['recipe_id', 'section_id']);

            $table->unsignedInteger('order')->default(0);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recipe_section');
    }
}
