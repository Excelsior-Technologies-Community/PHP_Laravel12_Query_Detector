<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PostExport;

class PostController extends Controller
{
    /**
     * Dashboard + Search + Filter + Pagination
     */
    public function index(Request $request)
    {
        $query = Post::with([
            'user',
            'category',
            'comments.user'
        ])
            ->withCount('comments');

        // Search
        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($user) use ($search) {
                        $user->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('category', function ($cat) use ($search) {
                        $cat->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // Category Filter
        if ($request->filled('category')) {

            $query->where('category_id', $request->category);
        }

        // Latest First
        $query->latest();

        // Pagination
        $posts = $query->paginate(5)->withQueryString();

        // Categories
        $categories = Category::orderBy('name')->get();

        // Dashboard Statistics
        $stats = [

            'posts'      => Post::count(),

            'categories' => Category::count(),

            'comments'   => \App\Models\Comment::count(),

            'views'      => Post::sum('views'),

            'latest'     => Post::latest()->first(),

        ];

        return view('posts.index', compact(
            'posts',
            'categories',
            'stats'
        ));
    }

    /**
     * N+1 Problem Demo
     */
    public function indexWithNPlusOne()
    {
        $posts = Post::paginate(5);

        return $this->dashboardView($posts);
    }

    public function indexWithEagerLoading()
    {
        $posts = Post::with([
            'user',
            'category',
            'comments.user'
        ])
            ->withCount('comments')
            ->paginate(5);

        return $this->dashboardView($posts);
    }

    public function indexWithSpecificRelations()
    {
        $posts = Post::with([
            'user:id,name',
            'category:id,name'
        ])
            ->withCount('comments')
            ->latest()
            ->paginate(5);

        return $this->dashboardView($posts);
    }


    /**
     * Lazy Eager Loading Demo
     */
    public function indexWithLazyEagerLoading()
    {
        $posts = Post::latest()->paginate(5);

        $posts->load(['user', 'category', 'comments.user']);

        return view('posts.index', compact('posts'));
    }

    /**
     * Export CSV
     */

    public function exportCsv()
    {
        $fileName = 'posts.csv';

        $posts = Post::with(['user', 'category'])
            ->withCount('comments')
            ->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$fileName}",
        ];

        $callback = function () use ($posts) {

            $file = fopen('php://output', 'w');

            fputcsv($file, [
                'ID',
                'Title',
                'Author',
                'Category',
                'Views',
                'Comments',
                'Created At'
            ]);

            foreach ($posts as $post) {

                fputcsv($file, [
                    $post->id,
                    $post->title,
                    optional($post->user)->name,
                    optional($post->category)->name,
                    $post->views,
                    $post->comments_count,
                    $post->created_at,
                ]);
            }

            fclose($file);
        };

        return response()->streamDownload($callback, $fileName, $headers);
    }

    /**
     * Single Post
     */
    public function show(Post $post)
    {
        $post->load([
            'user',
            'category',
            'comments.user'
        ]);

        return view('posts.show', compact('post'));
    }

    /**
     * Posts By Category
     */
    public function byCategory(Category $category)
    {
        $posts = Post::with([
            'user',
            'category',
            'comments.user'
        ])
            ->where('category_id', $category->id)
            ->withCount('comments')
            ->paginate(10);

        $categories = Category::all();

        $stats = [
            'posts' => Post::count(),
            'categories' => Category::count(),
            'comments' => \App\Models\Comment::count(),
            'views' => Post::sum('views'),
            'latest' => Post::latest()->first(),
        ];

        return view('posts.index', compact(
            'posts',
            'categories',
            'stats'
        ));
    }

    private function dashboardView($posts)
    {
        $categories = Category::orderBy('name')->get();

        $stats = [
            'posts' => Post::count(),
            'categories' => Category::count(),
            'comments' => \App\Models\Comment::count(),
            'views' => Post::sum('views'),
            'latest' => Post::latest()->first(),
        ];

        return view('posts.index', compact(
            'posts',
            'categories',
            'stats'
        ));
    }
}
