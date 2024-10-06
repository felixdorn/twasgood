<?php

use App\Models\Section;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('activation_periods', function (Blueprint $table) {
            $table->id();

            $table->string('type');
            $table->json('data')->nullable();

            $table->foreignIdFor(Section::class)->constrained()->cascadeOnDelete();

            $table->unique(['type', 'section_id']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activation_periods');
    }
};
