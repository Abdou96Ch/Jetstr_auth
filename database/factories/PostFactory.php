<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->realText($maxNbChars = 20, $indexSize = 2);
        return  [
            'title' => $title,
            'slug' => Str::slug($title),
            'body' => $this->faker->text(),
            'image' => $this->faker->imageUrl(640,480),
        ];
    }
}
