<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRecipeSectionPivotTable extends Migration
{
    public function up()
    {
        Schema::create('recipe_section', function (Blueprint $table) {
            $table->foreignId('recipe_id')->references('id')->on('recipes')->cascadeOnDelete();
            $table->foreignId('section_id')->references('id')->on('sections')->cascadeOnDelete();

            $table->primary(['recipe_id', 'section_id']);

            $table->unsignedInteger('order')->default(0);
        });
    }

    public function down()
    {
        Schema::dropIfExists('recipe_section');
    }
}
