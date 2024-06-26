<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\PostsComment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'post_id' => 'required|exists:posts,id',
            'content' => 'required',
            'user_id' => 'required|exists:users,id',
        ]);

        PostsComment::create([
            'post_id' => $request->post_id,
            'content' => $request->content,
            'user_id' => $request->user_id,
        ]);

        return redirect()->route('blogs.index');
    }
}
