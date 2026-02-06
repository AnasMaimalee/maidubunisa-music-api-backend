<?php

namespace Database\Factories;

use App\Models\Album;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AlbumFactory extends Factory
{
    protected $model = Album::class;

    public function definition(): array
    {
       
        return [
            'id'           => (string) Str::uuid(),
            'title'        => $this->faker->sentence(3),
            'release_date' => $this->faker->date(),
            'is_active'    => true,
        ];
    }
}

