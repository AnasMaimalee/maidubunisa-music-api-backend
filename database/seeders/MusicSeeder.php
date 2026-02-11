<?php

namespace Database\Seeders;

use App\Models\Album;
use Illuminate\Database\Seeder;

class MusicSeeder extends Seeder
{
    public function run(): void
    {
        Album::factory()
            ->count(5)
            ->hasSongs(8)
            ->create();
    }
}
