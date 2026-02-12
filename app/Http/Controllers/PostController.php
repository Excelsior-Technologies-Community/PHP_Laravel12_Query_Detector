<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;

class PostController extends Controller
{
    // ❌ N+1 Problem Example
    public function indexWithNPlusOne()
    {
        $posts = Post::all(); // This will cause N+1
        return view('posts.index', compact('posts'));
    }

    // ✅ Fixed with Eager Loading
    public function indexWithEagerLoading()
    {
        $posts = Post::with(['user', 'category', 'comments.user'])->get();
        return view('posts.index', compact('posts'));
    }

    // ✅ With counts
    public function indexWithSpecificRelations()
    {
        $posts = Post::with(['user:id,name', 'category:id,name'])
                     ->withCount('comments')
                     ->latest()
                     ->get();
        
        return view('posts.index', compact('posts'));
    }
}