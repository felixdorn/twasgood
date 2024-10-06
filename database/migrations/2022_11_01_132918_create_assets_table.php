<?php

use App\Models\Recipe;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Recipe::class);
            $table->string('path');
            $table->string('alt');
            $table->unsignedInteger('order')->nullable();

            $table->timestamps();
        });
    }
};
