<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$post->title}}</title>
</head>
<body>
    <h1>Show Post</h1>
    <div>
        <h2>{{ $post->title }}</h2>
        <p>{{ $post->body }}</p>
        <p>Author: {{ $post->author->name }}</p>
        <p>Published at: {{ $post->created_at->format("d.m.Y H:i:s") }}</p>
        <!--Notice how we navigate from Post to its Category simply by accessing a propety value! -->
        <p>Category: {{ $post->category->title }}</p>
        <h3>Comments:</h3>
        <ul>
            @foreach($post->comments as $comment)
                <li>
                    <p>{{ $comment->body }}</p>
                    <p>By: {{ $comment->author->name }}</p>
                    <p>Posted at: {{ $comment->created_at->format("d.m.Y H:i:s") }}</p>
                </li>
            @endforeach
        </ul>
    </div>
</body>
</html>
