@extends('layouts.app')

@section('title', 'Query Detector Dashboard')

@section('content')

<div class="container mx-auto px-4 py-6">

    <!-- Page Header -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-6">

        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                Query Detector Dashboard
            </h1>

            <p class="text-gray-500 mt-1">
                Search, Filter, Export and Query Performance Demo
            </p>
        </div>

        <div class="mt-4 md:mt-0">

            <a href="{{ route('posts.export') }}"
                class="btn btn-success">
                Export CSV
            </a>

        </div>

    </div>

    <!-- Dashboard Cards -->

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">

        <div class="bg-white rounded-lg shadow p-5">

            <p class="text-gray-500 text-sm">
                Total Posts
            </p>

            <h2 class="text-3xl font-bold text-blue-600 mt-2">
                {{ $stats['posts'] }}
            </h2>

        </div>

        <div class="bg-white rounded-lg shadow p-5">

            <p class="text-gray-500 text-sm">
                Categories
            </p>

            <h2 class="text-3xl font-bold text-purple-600 mt-2">
                {{ $stats['categories'] }}
            </h2>

        </div>

        <div class="bg-white rounded-lg shadow p-5">

            <p class="text-gray-500 text-sm">
                Comments
            </p>

            <h2 class="text-3xl font-bold text-pink-600 mt-2">
                {{ $stats['comments'] }}
            </h2>

        </div>

        <div class="bg-white rounded-lg shadow p-5">

            <p class="text-gray-500 text-sm">
                Total Views
            </p>

            <h2 class="text-3xl font-bold text-green-600 mt-2">
                {{ number_format($stats['views']) }}
            </h2>

        </div>

    </div>

    <!-- Latest Post -->

    @if($stats['latest'])

    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">

        <h3 class="font-semibold text-blue-700 mb-2">
            Latest Post
        </h3>

        <p class="font-bold">
            {{ $stats['latest']->title }}
        </p>

        <p class="text-sm text-gray-600">
            {{ $stats['latest']->created_at->diffForHumans() }}
        </p>

    </div>

    @endif

    <!-- Search & Filter -->

    <div class="bg-white rounded-lg shadow p-5 mb-6">

        <form
            action="{{ route('posts.index') }}"
            method="GET">

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

                <!-- Search -->

                <div>

                    <label class="block mb-2 text-sm font-semibold">
                        Search
                    </label>

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Title, Content, User..."
                        class="w-full border rounded-lg px-4 py-2">

                </div>

                <!-- Category -->

                <div>

                    <label class="block mb-2 text-sm font-semibold">
                        Category
                    </label>

                    <select
                        name="category"
                        class="w-full border rounded-lg px-4 py-2">

                        <option value="">
                            All Categories
                        </option>

                        @foreach($categories as $category)

                        <option
                            value="{{ $category->id }}"
                            @selected(request('category')==$category->id)>

                            {{ $category->name }}

                        </option>

                        @endforeach

                    </select>

                </div>

                <!-- Buttons -->

                <div class="flex items-end gap-2">

                    <button
                        class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded">

                        Search

                    </button>

                    <a
                        href="{{ route('posts.index') }}"
                        class="bg-gray-600 hover:bg-gray-700 text-white px-5 py-2 rounded">

                        Reset

                    </a>

                </div>

            </div>

        </form>

    </div>

    <!-- Posts List -->

    <div class="space-y-6">

        @forelse($posts as $post)

        <div class="bg-white rounded-lg shadow-lg overflow-hidden border">

            <!-- Header -->
            <div class="px-6 py-4 border-b bg-gray-50">

                <div class="flex flex-col md:flex-row justify-between">

                    <div>

                        <h2 class="text-2xl font-bold text-gray-800">
                            {{ $post->title }}
                        </h2>

                        <div class="flex flex-wrap items-center gap-3 mt-2 text-sm text-gray-600">

                            <span>
                                👤
                                {{ optional($post->user)->name ?? 'Unknown User' }}
                            </span>

                            @if($post->category)

                            <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full">
                                {{ $post->category->name }}
                            </span>

                            @endif

                            <span>
                                📅 {{ $post->created_at->format('d M Y') }}
                            </span>

                        </div>

                    </div>

                    <div class="mt-3 md:mt-0 text-right">

                        <div class="text-lg font-semibold text-green-600">

                            👁 {{ number_format($post->views) }}

                        </div>

                        <div class="text-sm text-gray-500">
                            Views
                        </div>

                    </div>

                </div>

            </div>

            <!-- Body -->

            <div class="p-6">

                <p class="text-gray-700 leading-7">

                    {{ \Illuminate\Support\Str::limit($post->content, 250) }}

                </p>

            </div>

            <!-- Statistics -->

            <div class="px-6 pb-4">

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

                    <div class="bg-gray-100 rounded-lg p-3 text-center">

                        <div class="text-xl font-bold text-blue-600">

                            {{ $post->comments_count }}

                        </div>

                        <div class="text-xs text-gray-500">

                            Comments

                        </div>

                    </div>

                    <div class="bg-gray-100 rounded-lg p-3 text-center">

                        <div class="text-xl font-bold text-green-600">

                            {{ $post->views }}

                        </div>

                        <div class="text-xs text-gray-500">

                            Views

                        </div>

                    </div>

                    <div class="bg-gray-100 rounded-lg p-3 text-center">

                        <div class="text-xl font-bold text-purple-600">

                            {{ optional($post->user)->name ?? '-' }}

                        </div>

                        <div class="text-xs text-gray-500">

                            Author

                        </div>

                    </div>

                    <div class="bg-gray-100 rounded-lg p-3 text-center">

                        <div class="text-xl font-bold text-red-600">

                            {{ optional($post->category)->name ?? '-' }}

                        </div>

                        <div class="text-xs text-gray-500">

                            Category

                        </div>

                    </div>

                </div>

            </div>

            <!-- Recent Comments -->

            @if($post->relationLoaded('comments'))

            <div class="border-t bg-gray-50 px-6 py-5">

                <h3 class="font-semibold text-gray-700 mb-4">

                    Recent Comments

                </h3>

                @forelse($post->comments->take(3) as $comment)

                <div class="mb-3 bg-white rounded-lg border p-4">

                    <div class="flex justify-between">

                        <strong>

                            {{ optional($comment->user)->name ?? 'Anonymous' }}

                        </strong>

                        <span class="text-gray-400 text-sm">

                            ❤️ {{ $comment->likes }}

                        </span>

                    </div>

                    <p class="mt-2 text-gray-600">

                        {{ \Illuminate\Support\Str::limit($comment->body,100) }}

                    </p>

                </div>

                @empty

                <div class="text-gray-500">

                    No comments available.

                </div>

                @endforelse

            </div>

            @endif

            <!-- Footer -->

            <div class="px-6 py-4 border-t bg-gray-50 flex justify-between items-center">

                <div class="text-sm text-gray-500">

                    Slug :

                    <strong>

                        {{ $post->slug }}

                    </strong>

                </div>

                <a href="{{ route('posts.show',$post->slug) }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg">

                    Read More

                </a>

            </div>

        </div>

        @empty

        <div class="bg-white rounded-lg shadow p-10 text-center">

            <h2 class="text-2xl font-bold text-gray-600">

                No Posts Found

            </h2>

            <p class="text-gray-500 mt-2">

                Try another search or category filter.

            </p>

        </div>

        @endforelse

    </div>

    <!-- Pagination -->
    <div class="mt-8">

        @if($posts instanceof \Illuminate\Contracts\Pagination\Paginator ||
        $posts instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator)
        {{ $posts->links() }}
        @endif

    </div>

    <!-- Query Detector Demo Information -->

    <div class="mt-10 bg-blue-50 border border-blue-200 rounded-lg p-6">

        <h2 class="text-xl font-bold text-blue-700 mb-4">
            Query Detector Demo
        </h2>

        <div class="grid md:grid-cols-2 gap-6">

            <div>

                <h3 class="font-semibold text-gray-700 mb-2">
                    Test Routes
                </h3>

                <ul class="space-y-2 text-sm">

                    <li>
                        <a href="{{ route('posts.nplusone') }}"
                            class="text-red-600 hover:underline">
                            ❌ N+1 Query Demo
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('posts.eager') }}"
                            class="text-green-600 hover:underline">
                            ✅ Eager Loading Demo
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('posts.optimized') }}"
                            class="text-blue-600 hover:underline">
                            🚀 Optimized Query Demo
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('posts.lazy') }}"
                            class="text-purple-600 hover:underline">
                            ⚡ Lazy Eager Loading Demo
                        </a>
                    </li>

                </ul>

            </div>

            <div>

                <h3 class="font-semibold text-gray-700 mb-2">
                    Available Features
                </h3>

                <ul class="list-disc ml-5 text-sm text-gray-700 space-y-1">

                    <li>Search Posts</li>

                    <li>Category Filter</li>

                    <li>Pagination</li>

                    <li>CSV Export</li>

                    <li>Dashboard Statistics</li>

                    <li>Query Detector Integration</li>

                    <li>N+1 Query Detection</li>

                    <li>Eager Loading Example</li>

                    <li>Optimized Relations</li>

                </ul>

            </div>

        </div>

    </div>

</div>

@endsection