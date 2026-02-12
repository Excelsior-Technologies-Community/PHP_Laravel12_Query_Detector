@extends('layouts.app')

@section('title', 'All Posts')

@section('content')
    <div class="mb-6">
        <h2 class="text-2xl font-bold">Blog Posts</h2>
    </div>

    <div class="grid gap-6">
        @forelse($posts as $post)
            <div class="bg-white rounded-lg shadow p-6">
                <!-- Post Header -->
                <div class="mb-4">
                    <h3 class="text-xl font-semibold">{{ $post->title }}</h3>
                    <div class="text-sm text-gray-600 mt-1">
                        <!-- Check if relationships exist -->
                        By {{ $post->user->name ?? 'Unknown User' }}
                        
                        @if($post->category)
                            in <span class="bg-gray-200 px-2 py-1 rounded">
                                {{ $post->category->name }}
                            </span>
                        @endif
                        
                        <span class="mx-2">•</span>
                        {{ $post->created_at->diffForHumans() }}
                        
                        @if(property_exists($post, 'comments_count'))
                            <span class="mx-2">•</span>
                            {{ $post->comments_count }} comments
                        @endif
                    </div>
                </div>

                <!-- Post Content -->
                <p class="text-gray-700 mb-4">
                    {{ Str::limit($post->content ?? 'No content', 200) }}
                </p>

                <!-- Comments Section -->
                @if($post->relationLoaded('comments'))
                <div class="border-t pt-4 mt-4">
                    <h4 class="font-semibold mb-3 text-gray-700">
                        Recent Comments
                    </h4>
                    
                    @forelse($post->comments->take(3) as $comment)
                        <div class="bg-gray-50 rounded p-3 mb-2">
                            <div class="flex justify-between">
                                <div>
                                    <span class="font-medium">
                                        {{ $comment->user->name ?? 'Anonymous' }}
                                    </span>
                                    <p class="text-gray-700 text-sm mt-1">
                                        {{ Str::limit($comment->body ?? '', 100) }}
                                    </p>
                                </div>
                                @if(isset($comment->likes))
                                <span class="text-xs text-gray-500">
                                    ❤️ {{ $comment->likes }}
                                </span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 text-sm">No comments yet</p>
                    @endforelse
                </div>
                @endif
            </div>
        @empty
            <p class="text-gray-500 text-center py-8">No posts found.</p>
        @endforelse
    </div>
@endsection