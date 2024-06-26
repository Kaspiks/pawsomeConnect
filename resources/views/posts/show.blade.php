<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <title>{{ $post->title }}</title>
</head>
<body>

    @php
        $menuItems = app(\App\Http\Controllers\NavigationController::class)->getMenuItems();
    @endphp

    <div>
        @include('layouts.nav', ['menuItems' => $menuItems])
    </div>

    <h1>Show Post</h1>
    <div>
        <h2>{{ $post->title }}</h2>
        <p>{{ $post->body }}</p>
        
        <!-- Check if author exists -->
        @if ($post->user)
            <p>Author: {{ $post->user->nickname }}</p>
        @else
            <p>Author: Unknown</p>
        @endif
        
        <p>Published at: {{ $post->created_at->format("d.m.Y H:i:s") }}</p>
        
        <!-- Check if category exists -->
        @if ($post->category)
            <p>Category: {{ $post->category->title }}</p>
        @else
            <p>Category: Dogs</p>
        @endif
        
        <h3>Comments:</h3>
        <ul>
            @foreach($post->comments as $comment)
                <li>
                    <p>{{ $comment->content }}</p>
                    
                    @if ($comment->user)
                        <p>By: {{ $comment->user->nickname }}</p>
                    @else
                        <p>By: Unknown</p>
                    @endif
                    
                    <p>Posted at: {{ $comment->created_at->format("d.m.Y H:i:s") }}</p>
                </li>
            @endforeach
        </ul>

        <!-- Comment Form -->
        @auth
            <form action="{{ route('comments.store', $post->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="content">Add Comment</label>
                    <textarea class="form-control" id="content" name="content" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submit Comment</button>
            </form>
        @else
            <p>Please <a href="{{ route('login') }}">login</a> to add comments.</p>
        @endauth
    </div>
</body>
</html>
