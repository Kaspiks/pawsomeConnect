<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pawsome Connect</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

@vite('resources/css/app.css')
</head>
<body>
    @php
        $menuItems = app(\App\Http\Controllers\NavigationController::class)->getMenuItems();
    @endphp

    <div>
        @include('layouts.nav', ['menuItems' => $menuItems])
    </div>

    <div class="posts-list">
        <!-- Create Post Button -->
        <div>
            <a href="{{ route('posts.create') }}" class="btn btn-primary">Create Post</a>
        </div>

        <!-- List of Posts -->
        @foreach ($posts as $post)
            <div class="post-item">
                <h2><a href="{{ route('posts.show', $post->id) }}">{{ $post->title }}</a></h2>
                @if ($post->user)
                    <p>An article by <em>{{ $post->user->nickname }}</em> published on {{ $post->created_at->format('d.m.y') }}</p>
                @else
                    <p>An article published on {{ $post->created_at->format('d.m.y') }}</p>
                @endif
                <p>{{ $post->body }}</p>
                @if ($post->image_path)
                    <img src="{{ asset('storage/' . $post->image_path) }}" alt="Post image" style="max-width: 100%;">
                @endif

                @can('update-post', $post)
                    <form method="POST" action="{{ route('posts.destroy', $post->id) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Delete post</button>
                    </form>

                    <form method="GET" action="{{ route('posts.edit', $post->id) }}">
                        <button type="submit">Update post</button>
                    </form>
                @endcan
            </div>
        @endforeach
    </div>
</body>
</html>
