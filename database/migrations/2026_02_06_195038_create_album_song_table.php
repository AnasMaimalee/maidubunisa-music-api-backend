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
        Schema::create('album_song', function (Blueprint $table) {
            $table->uuid('album_id');
            $table->uuid('song_id');

            $table->primary(['album_id', 'song_id']);

            $table->foreign('album_id')->references('id')->on('albums')->cascadeOnDelete();
            $table->foreign('song_id')->references('id')->on('songs')->cascadeOnDelete();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('album_song');
    }
};
