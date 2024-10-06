<?php

use App\Enums\Season;
use App\Models\Category;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Category::class)->constrained()->cascadeOnDelete();

            $table->string('banner')->nullable();
            $table->string('banner_thumbnail')->nullable();
            // text for legacy reasons
            $table->text('banner_alt');

            $table->string('title');
            $table->string('short_title');
            $table->string('season')->default(Season::All->value);
            // text for legacy reasons
            $table->text('description');
            $table->string('time_to_prepare')->nullable();
            $table->boolean('uses_sterilization')->default(false);
            $table->text('content');

            $table->boolean('publishable')->default(false);

            $table->softDeletes();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('recipes');
    }
};
