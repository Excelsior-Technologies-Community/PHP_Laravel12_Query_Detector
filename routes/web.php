<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CategoryController;

// N+1 Problem Demo
Route::get('/posts-n1', [PostController::class, 'indexWithNPlusOne'])
     ->name('posts.nplusone');

// Fixed with Eager Loading
Route::get('/posts-eager', [PostController::class, 'indexWithEagerLoading'])
     ->name('posts.eager');

// Advanced with condition
Route::get('/posts', [PostController::class, 'indexWithSpecificRelations'])
     ->name('posts.index');

// Single post
Route::get('/posts/{post:slug}', [PostController::class, 'show'])
     ->name('posts.show');

// Category posts
Route::get('/categories/{category:slug}', [PostController::class, 'byCategory'])
     ->name('categories.posts');

// Optional: Lazy eager loading demo
Route::get('/posts-lazy', [PostController::class, 'indexWithLazyEagerLoading'])
     ->name('posts.lazy');