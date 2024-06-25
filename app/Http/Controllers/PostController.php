<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::all()->sortByDesc('created_at');
        // $categories = Category::all()->keyBy('id');
        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!Auth::check()) {
            abort(403);
        }

        $users = User::all();

        return view('posts.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $users = User::all();

        if ($request->title == null || $request->user_id == null || $request->body == null) {
            //if you deleted everyting - go back and fill it!

            return redirect()->route('posts.create', compact('users'))->with('error', 'Failed to create post. Please try again.');
        }

        $post = Post::create([
            'title' => $request->title,
            'user_id' => $request->user_id,
            'body' => $request->body,
        ]);

        return redirect()->route('posts.show', $post->id)->with('success', 'Post has been created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::find($id);
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $post = Post::find($id);
        $users = User::all();

        return view('posts.edit', compact('post', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $post = Post::find($id);

        if (! Gate::allows('update-post', $post)) {
            abort(403);
        }

        if ($request->title == null || $request->user_id == null || $request->body == null) {
            //if you deleted everyting - go back and fill it!
            return redirect()->route('posts.edit', $id);
        }
        //all clear - updating the post!
        $post->title = $request->title;
        $post->user_id = $request->user_id;
        $post->body = $request->body;
        $post->save();
        return redirect()->route('posts.show', $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Post::findOrfail($id)->delete();
        return redirect()->route('posts.index');
    }
}
