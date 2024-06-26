<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\PostsComment;
use App\Models\PostsAttachment;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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

        $categories = Category::all();

        return view('posts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required',
            'category_id' => 'required|integer|exists:categories,id'
        ]);

        $user = Auth::user();

        $post = Post::create([
            'title' => $validate['title'],
            'user_id' => $user->id,
            'body' => $validate['body'],
            'category_id' => $validate['category_id']
        ]);

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('photos', 'public');
                $post->attachments()->create(['data' => $path]); 
            }
        }

        return redirect()->route('posts.show', $post->id)->with('success', 'Post has been created successfully');
    }

    public function show($id)
    {
        $individual = Auth::user();
        $post = Post::with('attachments')->findOrFail($id);

        $user = $post->user();
        return view('posts.show', compact('post', 'individual', 'user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if (!Auth::check()) {
            abort(403);
        }

        $categories = Category::all();
        $post = Post::with('attachments')->findOrFail($id);
        $user = $post->user();
        return view('posts.edit', compact('post', 'user', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        $validate = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required',
            'category_id' => 'required|integer|exists:categories,id'
        ]);
        
        $user = Auth::user();

        $post->title = $request['title'];
        $post->user_id = $user->id;
        $post->body = $request['body'];
        $post->category_id = $request['category_id'];

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('photos', 'public');
                PostsAttachment::create([
                    'data' => $path,
                    'event_id' => $post->id,
                ]);
            }
        }

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
    public function deleteAttachment(Post $post, PostsAttachment $attachment)
    {
        if ($attachment->post_id == $post->id) {
            Storage::disk('public')->delete($attachment->data);
            $attachment->delete();

            return response()->json(['message' => 'Attachment deleted successfully']);
        } else {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
    }
}
