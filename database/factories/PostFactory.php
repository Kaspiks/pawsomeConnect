<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition()
    {
        $title = $this->faker->sentence(5); // Generate a sentence with 5 words for the title

        // Generate paragraphs with specific sentences related to dogs and dog care
        $body = $this->faker->paragraphs(rand(3, 5), true);

        return [
            'title' => $title,
            'body' => $body,
            'user_id' => rand(1, 10), // Assuming you have users seeded already
            'category_id' => \App\Models\Category::inRandomOrder()->first()->id,
        ];
    }
}
