<?php

namespace Database\Factories;

use App\Models\Song;
use App\Models\Album;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class SongFactory extends Factory
{
    protected $model = Song::class;

    public function definition(): array
    {
        return [
            'id'         => (string) Str::uuid(),
            'album_id'   => Album::factory(),
            'title'      => $this->faker->sentence(2),
            'duration'   => rand(120, 400),
            'file_path'  => 'songs/audio/sample.mp3',
            'file_size'  => rand(1_000_000, 5_000_000),
            'checksum'   => hash('sha256', Str::random(40)),
            'is_active'  => true,
        ];
            }
}



