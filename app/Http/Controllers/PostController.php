<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\PostsComment;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch posts sorted by created_at in descending order, paginated
        $posts = Post::orderBy('created_at', 'desc')->paginate(10);
    
        $categories = Category::all()->keyBy('id');
    
        return view('posts.index', compact('posts', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!Auth::check()) {
            abort(403);
        }

        
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
            'body' => 'required',
        ]);

        $user = Auth::user();
         
        $post = new Post();
        $post->title = $request->title;
        $post->user_id = $user->id;
        $post->body = $request->body;
        $post->save();


        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $data['image_path'] = $imagePath;
        }


        return redirect()->route('posts.show', $post->id)->with('success', 'Post has been created successfully');
    }

    public function storeComment(Request $request, $postId)
    {
        $request->validate([
            'content' => 'required|string|max:255',
        ]);

        $user = Auth::user();

        $comment = new PostsComment();
        $comment->content = $request->content;
        $comment->user_id = $user->id;
        $comment->post_id = $postId;
        $comment->save();

        return redirect()->back()->with('success', 'Comment has been added successfully');
    }


    public function show($id)
    {
        $post = Post::findOrFail($id);
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);

        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
            'body' => 'required',
        ]);
        
        $user = Auth::user();

        $post->title = $request->title;
        $post->user_id = $user->id;
        $post->body = $request->body;
        $post->save();

        return redirect()->route('posts.show', $id)->with('success', 'Post has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Post has been deleted successfully');
    }
}
