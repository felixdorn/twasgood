<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('order')->nullable();
            $table->nullableMorphs('resource');
            $table->string('group')->nullable();
            $table->string('path')->nullable();
            $table->text('alt')->nullable();
            $table->timestamps();
        });
    }
};
