<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

@vite('resources/css/app.css')
    <title>Edit Post</title>
</head>
<body>

    @php
        $menuItems = app(\App\Http\Controllers\NavigationController::class)->getMenuItems();
    @endphp

    <div>
        @include('layouts.nav', ['menuItems' => $menuItems])
    </div>


    <h1>Edit Post</h1>


    <form action="{{ route('posts.update', $post->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" value="{{ old('title', $post->title) }}" required>
            @error('title')
                <div>{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="body">Body:</label>
            <textarea id="body" name="body" required cols="80" rows="20">{{ old('body', $post->body) }}</textarea>
            @error('body')
                <div>{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="category">Category:</label>
            <select id="category" name="category_id">
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ $category->id == $post->category_id ? 'selected' : '' }}>
                        {{ $category->title }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
                <div>{{ $message }}</div>
            @enderror
        </div>

        <button type="submit">Update</button>
    </form>
</body>
</html>
