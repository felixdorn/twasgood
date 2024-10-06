<?php

use App\Models\Recipe;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diagnoses', function (Blueprint $table) {
            $table->id();

            $table->string('type');
            $table->foreignIdFor(Recipe::class)->constrained()->cascadeOnDelete();

            $table->timestamp('ignored_at')->nullable();
            $table->timestamp('resolved_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     *     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('diagnoses');
    }
};
