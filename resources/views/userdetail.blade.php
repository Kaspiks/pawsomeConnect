<!-- resources/views/userdetail.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Detail</title>
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
    <main>
        <section class="user-detail container">
            <h2>My Profile</h2>
            <div class="user-info">
                <p><strong>Username:</strong> <span id="username">{{ Auth::user()->username }}</span></p>
                <p><strong>Email:</strong> <span id="email">{{ Auth::user()->email }}</span></p>
                <!-- Add other user details as needed -->
            </div>
            <h3>My Pets</h3>
            <div class="pet-grid" id="user-pets">
                @foreach(Auth::user()->pets as $pet)
                    <div class="pet-card">
                        <a href="{{ route('pets.show', $pet->id) }}">
                            <img src="{{ asset('images/pet-placeholder.png') }}" alt="Pet Image Placeholder">
                            <h4>{{ $pet->name }}</h4>
                            <p><strong>Breed:</strong> {{ $pet->breed }}</p>
                            <p>{{ $pet->description }}</p>
                        </a>
                    </div>
                @endforeach
            </div>

            <h3>My Posts</h3>
            <div class="post-grid" id="user-posts">
                @if (Auth::user()->posts)
                    @foreach(Auth::user()->posts as $post)
                        <div class="post-card">
                            <a href="{{ route('posts.show', $post->id) }}">
                                <h4>{{ $post->title }}</h4>
                                <p>{{ $post->created_at->format('M d, Y') }}</p>
                                <p>{{ Str::limit($post->body, 150) }}</p>
                            </a>
                        </div>
                    @endforeach
                @else
                    <p>No posts found.</p>
                @endif
            </div>
        </section>
    </main>
    <footer>
        <div class="container">
            <p>Disclaimer: The information provided on this website is for informational purposes only.</p>
            <span>Copyright © {{ date('Y') }} All Rights Reserved.</span>
        </div>
    </footer>
    <script src="{{ asset('js/user-detail.js') }}"></script>
</body>
</html>
