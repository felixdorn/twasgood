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
        Schema::create('prerequisites', function (Blueprint $table) {
            $table->id();

            $table->string('details')->nullable();
            $table->string('quantity');
            $table->boolean('optional')->default(false);
            $table->unsignedInteger('order')->nullable();

            $table->foreignIdFor(Recipe::class)->constrained()->cascadeOnDelete();
            $table->morphs('prerequisite');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prerequisites');
    }
};
