<?php

// database/factories/CommentFactory.php

namespace Database\Factories;

use App\Models\PostsComment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostsCommentFactory extends Factory
{
    protected $model = PostsComment::class;

    public function definition()
    {
        return [
            'post_id' => Post::inRandomOrder()->first()->id,
            'user_id' => User::inRandomOrder()->first()->id,
            'content' => $this->faker->paragraph,
        ];
    }
}
