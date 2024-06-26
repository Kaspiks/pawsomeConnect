<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @vite('resources/css/app.css') 
    <title>{{ $post->title }}</title>
</head>
<body>

    @php
        $menuItems = app(\App\Http\Controllers\NavigationController::class)->getMenuItems();
    @endphp

    <div>
        @include('layouts.nav', ['menuItems' => $menuItems])
    </div>

    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Show Post</h1>
    
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold mb-2">{{ $post->title }}</h2>
            <p class="mb-4">{{ $post->body }}</p>
    
            @if ($post->user)
                <p class="text-gray-600">Author: {{ $post->user->nickname }}</p>
            @else
                <p class="text-gray-600">Author: Unknown</p>
            @endif
    
            <p class="text-gray-600">Published at: {{ $post->created_at->format("d.m.Y H:i:s") }}</p>
    
            @if ($post->category)
                <p class="text-gray-600">Category: {{ $post->category->title }}</p>
            @else
                <p class="text-gray-600">Category: Dogs</p>
            @endif
        </div>

        @if ($post->attachments->isNotEmpty())
            <div class="mt-8 mb-12 border rounded-lg overflow-hidden">
                <div class="grid grid-cols-2 md:grid-cols-2 gap-4 md:gap-6 px-4 md:px-8 py-4">
                    @foreach ($post->attachments as $attachment)
                        <div class="relative overflow-hidden rounded-lg shadow-md">
                            <a href="{{ asset('storage/' . $attachment->data) }}" data-lightbox="event-gallery">
                                <img class="object-cover w-full h-full" src="{{ asset('storage/' . $attachment->data) }}" alt="">
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
        
        <h3 class="text-lg font-semibold mt-6 mb-4">Comments:</h3>
        <ul class="space-y-4">
            @foreach($post->comments as $comment)
                <li class="bg-gray-100 p-4 rounded-md">
                    <p>{{ $comment->content }}</p>
                    @if ($comment->user)
                        <p class="text-gray-600">By: {{ $comment->user->nickname }}</p>
                    @else
                        <p class="text-gray-600">By: Unknown</p>
                    @endif
                    <p class="text-gray-600">Posted at: {{ $comment->created_at->format("d.m.Y H:i:s") }}</p>
                </li>
            @endforeach
        </ul>

        @auth
            <form action="{{ route('comments.store', $post->id) }}" method="POST" class="mt-6 space-y-4">
                @csrf
                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700">Add Comment</label>
                    <textarea id="content" name="content" rows="3" class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"></textarea>
                </div>
                <button type="submit" class="bg-gray-800 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Submit Comment</button>
            </form>
        @endauth
    </div>
</body>
</html>
