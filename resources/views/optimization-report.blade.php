@extends('layouts.app')

@section('title', 'Query Optimization Report')

@section('content')

<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-800"> Query Optimization Report </h1>

    <p class="mt-2 text-gray-600">
        Analyze the N+1 query pattern and learn how to optimize Eloquent relationships.
    </p>

</div>

{{-- Detection Summary --}}

<div class="bg-white rounded-xl shadow p-6 mb-8">

    <div class="flex items-start gap-4">

        <div class="text-4xl">
            🔍
        </div>

        <div>
            <h2 class="text-xl font-semibold text-red-600">
                N+1 Query Pattern Analysis
            </h2>

            <p class="text-gray-600 mt-2">
                Accessing related models inside loops can generate unnecessary
                database queries.
            </p>
        </div>

    </div>

</div>

{{-- Statistics --}}

<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">

    <div class="bg-white rounded-xl shadow p-6">
        <p class="text-sm text-gray-500">
            Posts
        </p>

        <h2 class="text-3xl font-bold text-gray-800 mt-2">
            {{ $posts }}
        </h2>
    </div>

    <div class="bg-white rounded-xl shadow p-6">
        <p class="text-sm text-gray-500">
            N+1 Queries
        </p>

        <h2 class="text-3xl font-bold text-red-600 mt-2">
            {{ $n1Queries }}
        </h2>
    </div>

    <div class="bg-white rounded-xl shadow p-6">
        <p class="text-sm text-gray-500">
            Optimized Queries
        </p>

        <h2 class="text-3xl font-bold text-green-600 mt-2">
            {{ $optimizedQueries }}
        </h2>
    </div>

    <div class="bg-white rounded-xl shadow p-6">
        <p class="text-sm text-gray-500">
          Potentially Avoidable Queries
        </p>

        <h2 class="text-3xl font-bold text-orange-600 mt-2">
            {{ $unnecessaryQueries }}
        </h2>
    </div>

</div>

{{-- Problem --}}

<div class="bg-white rounded-xl shadow p-6 mb-8">

    <h2 class="text-xl font-semibold text-gray-800 mb-4">
        🔍 Problematic Approach
    </h2>

    <p class="text-gray-600 mb-4">
        The following approach loads posts first and then accesses related
        models individually.
    </p>

    <div class="bg-gray-900 rounded-lg p-5 overflow-x-auto">
        <pre class="text-gray-100 text-sm"><code>$posts = Post::all();

foreach ($posts as $post) {
$post->user;
$post->category;

foreach ($post->comments as $comment) {
    $comment->user;
}

}</code></pre>
    </div>

</div>

{{-- Recommended Fix --}}

<div class="bg-white rounded-xl shadow p-6 mb-8">

    <h2 class="text-xl font-semibold text-gray-800 mb-4">
        💡 Recommended Eloquent Fix
    </h2>

    <p class="text-gray-600 mb-4">
        Load the required relationships before the loop using eager loading.
    </p>

    <div class="bg-gray-900 rounded-lg p-5 overflow-x-auto">
        <pre class="text-green-400 text-sm"><code>$posts = Post::with([
'user',
'category',
'comments.user'

])->get();</code></pre>
    </div>

</div>

{{-- Optimization Result --}}

<div class="bg-white rounded-xl shadow p-6 mb-8">

    <h2 class="text-xl font-semibold text-gray-800 mb-4">
        📈 Optimization Result
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <div>
            <p class="text-sm text-gray-500">
                Query Reduction
            </p>

            <p class="text-2xl font-bold text-green-600 mt-1">
                {{ $unnecessaryQueries }} queries
            </p>
        </div>

        <div>
            <p class="text-sm text-gray-500">
                Optimization Rate
            </p>

            <p class="text-2xl font-bold text-green-600 mt-1">
                {{ $optimizationPercentage }}%
            </p>
        </div>

        <div>
            <p class="text-sm text-gray-500">
                Recommended Strategy
            </p>

            <p class="text-2xl font-bold text-blue-600 mt-1">
                Eager Loading
            </p>
        </div>

    </div>

</div>

{{-- Best Practices --}}

<div class="bg-white rounded-xl shadow p-6">

    <h2 class="text-xl font-semibold text-gray-800 mb-5">
        🛠️ Query Optimization Best Practices
    </h2>

    <div class="space-y-4">

        <div class="flex gap-3">
            <span class="text-green-600 font-bold">✓</span>

            <p class="text-gray-700">
                Use <code class="bg-gray-100 px-2 py-1 rounded">with()</code>
                for relationships required before rendering.
            </p>
        </div>

        <div class="flex gap-3">
            <span class="text-green-600 font-bold">✓</span>

            <p class="text-gray-700">
                Use
                <code class="bg-gray-100 px-2 py-1 rounded">withCount()</code>
                instead of loading an entire relationship just to count it.
            </p>
        </div>

        <div class="flex gap-3">
            <span class="text-green-600 font-bold">✓</span>

            <p class="text-gray-700">
                Select only the columns required by the application.
            </p>
        </div>

        <div class="flex gap-3">
            <span class="text-green-600 font-bold">✓</span>

            <p class="text-gray-700">
                Avoid accessing relationships inside large loops without
                eager loading.
            </p>
        </div>

        <div class="flex gap-3">
            <span class="text-green-600 font-bold">✓</span>

            <p class="text-gray-700">
                Use pagination when working with large datasets.
            </p>
        </div>

    </div>

</div>

@endsection