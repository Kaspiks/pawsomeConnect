<?php

// database/seeders/CommentsTableSeeder.php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\PostsComment;
use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder
{
    public function run()
    {
        // Get all posts
        $posts = Post::all();

        // Create comments for each post
        $posts->each(function ($post) {
            PostsComment::factory()->count((5))->create([
                'post_id' => $post->id,
            ]);
        });
    }
}
