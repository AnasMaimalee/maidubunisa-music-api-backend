<?php

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
        Schema::create('songs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('album_id');
            $table->string('title');
            $table->integer('duration');
            $table->string('file_path');
            $table->bigInteger('file_size');
            $table->string('checksum');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->foreign('album_id')->references('id')->on('albums')->cascadeOnDelete();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('songs');
    }
};
