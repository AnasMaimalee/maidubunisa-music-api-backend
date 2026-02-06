<?php

namespace Database\Seeders;

use App\Models\Album;
use Illuminate\Database\Seeder;

class MusicSeeder extends Seeder
{
    public function run(): void
    {
        Album::factory()
            ->count(20)
            ->hasSongs(50)
            ->create();
    }
}
