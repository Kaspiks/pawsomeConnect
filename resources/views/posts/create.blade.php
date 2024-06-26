<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create New Post</title>
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

    <div class="container">
        <h1>Create New Post</h1>
        <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" id="title" name="title" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="body">Body</label>
                <textarea id="body" name="body" class="form-control" rows="6" required></textarea>
            </div>

            <div class="form-group">
                <label for="image">Upload Image</label>
                <input type="file" id="image" name="image" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Create Post</button>
        </form>
    </div>
</body>
</html>
