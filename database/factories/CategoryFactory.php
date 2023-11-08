<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->word;
        $slug = Str::slug($title, '-');
        return [
            'title'=>$title,
            'slug'=>$slug,
            'photo'=>fake()->image,
            'summary'=>fake()->paragraph,

        ];
    }
}
