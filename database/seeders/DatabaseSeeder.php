<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Create users
        User::factory(5)->create();

        // Create categories
        $categories = ['Technology', 'Lifestyle', 'Travel', 'Food', 'Health'];
        foreach ($categories as $category) {
            Category::create([
                'name' => $category,
                'slug' => strtolower($category)
            ]);
        }

        // Create posts with comments
        User::all()->each(function ($user) {
            Post::factory(3)->create([
                'user_id' => $user->id,
                'category_id' => Category::inRandomOrder()->first()->id
            ])->each(function ($post) {
                Comment::factory(5)->create([
                    'post_id' => $post->id,
                    'user_id' => User::inRandomOrder()->first()->id
                ]);
            });
        });
    }
}