<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition()
    {
        $categories = [
            'Breeds',
            'Health Care',
            'Training',
            'Nutrition',
            'Grooming',
            'Behavior',
        ];

        return [
            'title' => $this->faker->unique()->randomElement($categories),
        ];
    }
}
