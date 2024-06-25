<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Pawsome connect</title>
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

    {{-- @include('layouts.navigation', ['menuItems' => App\Http\Controllers\NavigationController::getMenuItems()]) --}}


    @foreach ($posts as $post)
        <h2><a href="{{ route('posts.show', $post->id) }}">{{ $post->title }}</a></h2>
        <p>An article by <em>{{$post->user->name}}</em> published on {{$post->created_at->format('d.m.y')}}
        </p>
        <p>{{ $post->body }}</p>

        @can('update-post', $post)
            <p><form method="POST" action="{{ route('posts.destroy', $post->id) }}">
                @csrf
                @method('DELETE')
                <button type="submit">Delete post</button>
            </form></p>

            <p><form method="GET" action="{{ route('posts.edit', $post->id) }}">
                @csrf
                <button type="submit">Update post</button>
            </form></p>
        @endcan
    @endforeach
</body>
</html>
