<?php

namespace App\Console\Commands;

use App\Models\Post;
use Illuminate\Console\Command;

class TestQueryDetector extends Command
{
    protected $signature = 'test:query-detector';
    protected $description = 'Test the Query Detector package';

    public function handle()
    {
        $this->info('Testing N+1 Query Problem...');
        
        // This will trigger N+1
        $posts = Post::all();
        
        foreach ($posts as $post) {
            $this->line("Post: {$post->title}");
            foreach ($post->comments as $comment) {
                $this->line("- Comment by: {$comment->user->name}");
            }
        }
        
        $this->info('Check your browser console for query warnings!');
    }
}