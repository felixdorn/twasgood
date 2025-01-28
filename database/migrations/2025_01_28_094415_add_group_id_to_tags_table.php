<?php

use App\Models\TagGroup;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tags', function (Blueprint $table) {
            $table->foreignIdFor(TagGroup::class)->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('tags', function (Blueprint $table) {
            //
        });
    }
};
