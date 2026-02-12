<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition()
    {
        $title = $this->faker->sentence;
        
        return [
            'title' => $title,
            'slug' => str_replace(' ', '-', $title),
            'content' => $this->faker->paragraphs(3, true),
            'views' => $this->faker->numberBetween(0, 1000)
        ];
    }
}