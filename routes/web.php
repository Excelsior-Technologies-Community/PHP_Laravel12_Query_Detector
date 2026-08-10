<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

/*
|--------------------------------------------------------------------------
| Home
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
     return redirect()->route('posts.index');
});


/*
|--------------------------------------------------------------------------
| Posts Dashboard (Search + Filter + Pagination)
|--------------------------------------------------------------------------
*/

Route::get('/posts', [PostController::class, 'index'])
     ->name('posts.index');


/*
|--------------------------------------------------------------------------
| Query Detector Demo Routes
|--------------------------------------------------------------------------
*/

// ❌ N+1 Query Example
Route::get('/posts-n1', [PostController::class, 'indexWithNPlusOne'])
     ->name('posts.nplusone');

// ✅ Eager Loading Example
Route::get('/posts-eager', [PostController::class, 'indexWithEagerLoading'])
     ->name('posts.eager');

// ✅ Specific Relations Example
Route::get('/posts-optimized', [PostController::class, 'indexWithSpecificRelations'])
     ->name('posts.optimized');

// ✅ Lazy Eager Loading
Route::get('/posts-lazy', [PostController::class, 'indexWithLazyEagerLoading'])
     ->name('posts.lazy');


/*
|--------------------------------------------------------------------------
| Export
|--------------------------------------------------------------------------
*/

Route::get('/posts/export/csv', [PostController::class, 'exportCsv'])
     ->name('posts.export');

/*
|--------------------------------------------------------------------------
| Single Post
|--------------------------------------------------------------------------
*/

Route::get('/posts/{post:slug}', [PostController::class, 'show'])
     ->name('posts.show');


/*
|--------------------------------------------------------------------------
| Category Posts
|--------------------------------------------------------------------------
*/

Route::get('/categories/{category:slug}', [PostController::class, 'byCategory'])
     ->name('categories.posts');


Route::get('/benchmark', [PostController::class, 'benchmark'])
    ->name('benchmark');

Route::get('/optimization-report', [PostController::class, 'optimizationReport'])
    ->name('optimization.report');