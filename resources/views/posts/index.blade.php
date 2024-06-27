<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pawsome Connect</title>
    @vite('resources/css/app.css')
</head>
<body>
    @php
        $menuItems = app(\App\Http\Controllers\NavigationController::class)->getMenuItems();
    @endphp

    <div>
        @include('layouts.nav', ['menuItems' => $menuItems])
    </div>

    <div class="container mx-auto p-4 bg-white">
        @auth
            <div>
                <a href="{{ route('posts.create') }}" class="bg-gray-800 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Create Post
                </a>
            </div>
        @endauth

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-4">
            @foreach ($posts as $post)
                <div class="bg-gray-50 rounded-lg shadow-md overflow-hidden">
                    @if ($post->attachments->first())
                        <img src="{{ asset('storage/' . $post->attachments->first()->data) }}" alt="Post Banner" class="w-full h-48 object-cover">
                    @endif

                    <div class="p-4">
                        <a href="{{ route('posts.show', $post->id) }}">
                            <h2 class="text-xl font-semibold mb-2">{{ $post->title }}</h2>
                        </a>

                        @if ($post->user)
                            <p class="text-gray-600">An article by
                                <a href="{{ route('profile.show', $post->user->id) }}" class="text-gray-600 hover:underline">
                                    <em>{{ $post->user->nickname }}</em>
                                </a>
                                published on {{ $post->created_at->format('d.m.y') }}
                            </p>
                        @else
                            <p class="text-gray-600">An article published on {{ $post->created_at->format('d.m.y') }}</p>
                        @endif

                        <p class="text-gray-700 mt-2">{{ Str::limit($post->body, 150) }}</p>

                        @if(isset($categories[$post->category_id]))
                            <p class="text-gray-600 mt-2">in category {{ $categories[$post->category_id]->title }}</p>
                        @else
                            <p class="text-gray-600 mt-2">in an undefined category</p>
                        @endif

                        @can('update-post', $post)
                            <div class="flex justify-end mt-4 space-x-2">
                                <form method="POST" action="{{ route('posts.destroy', $post->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-gray-800 hover:bg-gray-700 text-white font-bold py-1 px-2 rounded text-sm">Delete</button>
                                </form>

                                <form method="GET" action="{{ route('posts.edit', $post->id) }}">
                                    <button type="submit" class="bg-gray-800 hover:bg-gray-700 text-white font-bold py-1 px-2 rounded text-sm">Update</button>
                                </form>
                            </div>
                        @endcan
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</body>
</html>
