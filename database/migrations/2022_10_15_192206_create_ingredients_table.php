<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ingredients', function (Blueprint $table) {
            $table->id();

            $table->string('name')->unique();
            $table->string('type'); // vegan, vegetarian, meat
            $table->boolean('contains_gluten')->default(false);
            $table->boolean('contains_dairy')->default(false);

            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ingredients');
    }
};
