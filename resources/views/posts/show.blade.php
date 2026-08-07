@extends('layouts.app')

@section('title', $post->title)

@section('content')

<div class="container py-5">

    <!-- Back Button -->
    <div class="mb-4">
        <a href="{{ route('posts.index') }}" class="btn btn-outline-primary rounded-pill px-4">
            ← Back to Dashboard
        </a>
    </div>

    <!-- Hero Card -->
    <div class="card border-0 shadow-lg overflow-hidden">

        <div class="card-header border-0 text-white py-5"
            style="background:linear-gradient(135deg,#2563eb,#4f46e5);">

            <div class="d-flex justify-content-between align-items-start flex-wrap">

                <div>

                    <span class="badge bg-light text-primary px-3 py-2 rounded-pill mb-3">
                        {{ optional($post->category)->name }}
                    </span>

                    <h1 class="fw-bold mb-2">
                        {{ $post->title }}
                    </h1>

                    <div class="text-white-50">

                        <span class="me-4">
                            👤 {{ optional($post->user)->name }}
                        </span>

                        <span>
                            📅 {{ $post->created_at->format('d M Y') }}
                        </span>

                    </div>

                </div>

            </div>

        </div>

        <div class="card-body p-5">

            <!-- Statistics -->

            <div class="row g-4 mb-5">

                <div class="col-md-3">

                    <div class="card border-0 shadow-sm bg-primary bg-opacity-10">

                        <div class="card-body text-center">

                            <h2 class="fw-bold text-primary">
                                {{ number_format($post->views) }}
                            </h2>

                            <small class="text-muted">
                                Total Views
                            </small>

                        </div>

                    </div>

                </div>

                <div class="col-md-3">

                    <div class="card border-0 shadow-sm bg-success bg-opacity-10">

                        <div class="card-body text-center">

                            <h2 class="fw-bold text-success">
                                {{ $post->comments->count() }}
                            </h2>

                            <small class="text-muted">
                                Comments
                            </small>

                        </div>

                    </div>

                </div>

                <div class="col-md-3">

                    <div class="card border-0 shadow-sm bg-warning bg-opacity-10">

                        <div class="card-body text-center">

                            <h5 class="fw-bold text-warning">
                                {{ optional($post->category)->name }}
                            </h5>

                            <small class="text-muted">
                                Category
                            </small>

                        </div>

                    </div>

                </div>

                <div class="col-md-3">

                    <div class="card border-0 shadow-sm bg-info bg-opacity-10">

                        <div class="card-body text-center">

                            <h5 class="fw-bold text-info">
                                {{ optional($post->user)->name }}
                            </h5>

                            <small class="text-muted">
                                Author
                            </small>

                        </div>

                    </div>

                </div>

            </div>

            <!-- Content -->

            <div class="card border-0 shadow-sm mb-5">

                <div class="card-header bg-light">

                    <h4 class="mb-0 fw-bold text-primary">
                        📄 Article Content
                    </h4>

                </div>

                <div class="card-body">

                    <div class="fs-5 text-secondary" style="line-height:2;">

                        {!! nl2br(e($post->content)) !!}

                    </div>

                </div>

            </div>

            <!-- Comments -->

            <div class="card border-0 shadow-sm">

                <div class="card-header bg-light d-flex justify-content-between align-items-center">

                    <h4 class="mb-0 fw-bold text-primary">
                        💬 Comments
                    </h4>

                    <span class="badge bg-primary rounded-pill">
                        {{ $post->comments->count() }}
                    </span>

                </div>

                <div class="card-body">

                    @forelse($post->comments as $comment)

                    <div class="card border-0 shadow-sm mb-4">

                        <div class="card-body">

                            <div class="d-flex justify-content-between align-items-center">

                                <div>

                                    <h6 class="fw-bold text-dark mb-1">

                                        👤 {{ optional($comment->user)->name ?? 'Anonymous' }}

                                    </h6>

                                    <small class="text-muted">

                                        {{ $comment->created_at->diffForHumans() }}

                                    </small>

                                </div>

                                <span class="badge bg-danger rounded-pill px-3 py-2">

                                    ❤️ {{ $comment->likes }}

                                </span>

                            </div>

                            <hr>

                            <p class="mb-0 text-secondary">

                                {{ $comment->body }}

                            </p>

                        </div>

                    </div>

                    @empty

                    <div class="text-center py-5">

                        <img src="https://cdn-icons-png.flaticon.com/512/4076/4076549.png"
                            width="120"
                            class="mb-3">

                        <h4 class="text-secondary">
                            No Comments Yet
                        </h4>

                        <p class="text-muted">
                            Be the first to comment on this post.
                        </p>

                    </div>

                    @endforelse

                </div>

            </div>

        </div>

        <div class="card-footer bg-white border-0 py-4">

            <div class="d-flex justify-content-between flex-wrap">

                <div>

                    <strong class="text-primary">
                        Slug
                    </strong>

                    <br>

                    <span class="text-muted">
                        {{ $post->slug }}
                    </span>

                </div>

                <div class="text-end">

                    <strong class="text-primary">
                        Created
                    </strong>

                    <br>

                    <span class="text-muted">
                        {{ $post->created_at->format('d M Y h:i A') }}
                    </span>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection