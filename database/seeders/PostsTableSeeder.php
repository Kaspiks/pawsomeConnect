<?php

// database/seeders/PostsTableSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;

class PostsTableSeeder extends Seeder
{
    public function run()
    {
        $user = User::first(); // Assuming you have a user in your database

        // Assuming you have a category 'Dogs' with id 1 in your categories table
        $category = Category::find(1);

        $posts = [
            [
                'title' => 'Best Dog Breeds for Families',
                'body' => 'Choosing the right dog breed for your family involves considering factors like size, temperament, and energy level. Some popular family-friendly dog breeds include Labrador Retrievers, Golden Retrievers, and Beagles.',
            ],
            [
                'title' => 'Dog Nutrition Basics',
                'body' => 'Proper nutrition is essential for a dog\'s health. Dogs require a balanced diet that includes proteins, carbohydrates, fats, vitamins, and minerals. Consult with your veterinarian to determine the best diet for your dog.',
            ],
            [
                'title' => 'Basic Dog Training Tips',
                'body' => 'Training your dog is important for their safety and your sanity. Start with basic commands like sit, stay, and come. Use positive reinforcement techniques such as treats and praise to encourage good behavior.',
            ],
            [
                'title' => 'Grooming Your Dog at Home',
                'body' => 'Regular grooming helps keep your dog healthy and looking their best. Brush your dog\'s coat to remove dirt and debris, trim their nails, and clean their ears regularly. Consider professional grooming for specialized care.',
            ],
            [
                'title' => 'Common Health Issues in Dogs',
                'body' => 'Dogs can experience various health issues, including fleas and ticks, dental problems, allergies, and obesity. Regular veterinary check-ups and preventive care can help detect and manage these issues early.',
            ],
            [
                'title' => 'Creating a Safe Environment for Your Dog',
                'body' => 'Ensure your home and yard are safe for your dog by removing hazardous substances, securing fences, and providing a comfortable living space. Supervise outdoor activities to prevent accidents and injuries.',
            ],
            [
                'title' => 'Understanding Dog Behavior',
                'body' => 'Dog behavior is influenced by genetics, environment, and training. Learn to interpret your dog\'s body language and vocalizations to better understand their needs and emotions.',
            ],
        ];

        foreach ($posts as $post) {
            Post::create([
                'title' => $post['title'],
                'body' => $post['body'],
                'user_id' => $user->id,
                'category_id' => $category->id,
            ]);
        }
    }
}
