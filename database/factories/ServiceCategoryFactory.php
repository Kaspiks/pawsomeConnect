<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ServiceCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = [
            'Pet Grooming' => 'Professional grooming services to keep your furry friend looking and feeling their best.',
            'Dog Walking' => 'Regular walks to exercise and socialize your dog.',
            'Pet Sitting' => 'Loving care for your pets while you are away.',
            'Veterinary Care' => 'Medical care and checkups for your pets.',
            'Pet Training' => 'Training services to help your pets learn good behavior.',
            'Pet Boarding' => 'Safe and comfortable accommodation for your pets while you travel.',
            'Pet Taxi' => 'Transportation services for your pets to appointments or other destinations.',
            'Pet Photography' => 'Professional photoshoots to capture your pet\'s personality.',
            'Pet Nutrition Consultation' => 'Expert advice on the best diet for your pet\'s health and well-being.',
            'Pet Massage/Therapy' => 'Relaxing and therapeutic massages for your pets.',
            'Pet Waste Removal' => 'Regular cleaning of your yard to keep it free of pet waste.',
            'Pet Daycare' => 'Supervised playtime and socialization for your pets during the day.',
            'Pet Adoption Services' => 'Help finding loving homes for pets in need.',
            'Exotic Pet Care' => 'Specialized care for unique and exotic pets.',
            'Pet Memorial Services' => 'Commemorative services to honor the memory of your beloved pet.',
        ];

        $category = $this->faker->randomElement(array_keys($categories));
        $description = $categories[$category];

        return [
            'name' => $category,
            'description' => $description,
        ];

    }
}
