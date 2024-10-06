<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRecipeTagPivotTable extends Migration
{
    public function up()
    {
        Schema::create('recipe_tag', function (Blueprint $table) {
            $table->foreignId('recipe_id')->references('id')->on('recipes')->cascadeOnDelete();
            $table->foreignId('tag_id')->references('id')->on('tags')->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('recipe_tag');
    }
}
