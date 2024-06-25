<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ServiceCategory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Service>
 */
class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $serviceCategories = [
            'Pet Grooming' => ['Basic Grooming Package', 'Deluxe Grooming Package', 'Nail Trim', 'Ear Cleaning', 'Teeth Brushing'],
            'Dog Walking' => ['30-Minute Dog Walk', '60-Minute Dog Walk', 'Group Dog Walk', 'Hiking with Your Dog'],
            'Pet Sitting' => ['Pet Sitting (Overnight)', 'Pet Sitting (Daily Visits)', 'Pet Sitting with Daily Walks', 'Pet Sitting for Multiple Pets'],
            'Veterinary Care' => ['Basic Vet Checkup', 'Vaccination Package', 'Dental Cleaning', 'Surgical Consultation'],
            'Pet Training' => ['Puppy Training Course', 'Obedience Training Course', 'Agility Training', 'Behavior Modification'],
            'Pet Boarding' => ['Kennel Boarding', 'Luxury Pet Suite', 'Boarding with Playtime', 'Boarding for Special Needs Pets'],
            'Pet Taxi' => ['Pet Transport to Vet', 'Pet Transport to Airport', 'Pet Transport to Groomer', 'Pet Transport for Errands'],
            'Pet Photography' => ['Pet Portrait Session', 'Outdoor Pet Photoshoot', 'Pet and Family Photoshoot', 'Pet Action Shots'],
            'Pet Nutrition Consultation' => ['Personalized Diet Plan', 'Nutritional Assessment', 'Weight Management Consultation', 'Food Allergy Consultation'],
            'Pet Massage/Therapy' => ['Relaxation Massage for Pets', 'Deep Tissue Massage for Pets', 'Hydrotherapy Session', 'Therapeutic Ultrasound'],
            'Pet Waste Removal' => ['Yard Waste Removal (Weekly)', 'Yard Waste Removal (Monthly)', 'Yard Waste Removal (One-Time)'],
            'Pet Daycare' => ['Half-Day Doggy Daycare', 'Full-Day Doggy Daycare', 'Daycare with Training', 'Small Dog Daycare'],
            'Pet Adoption Services' => ['Adoption Counseling', 'Home Visit Assessment', 'Adoption Events', 'Post-Adoption Support'],
            'Exotic Pet Care' => ['Reptile Care', 'Bird Care', 'Small Mammal Care', 'Fish Tank Maintenance'],
            'Pet Memorial Services' => ['Private Cremation', 'Communal Cremation', 'Burial Services', 'Memorial Jewelry'],
        ];

        $category = $this->faker->randomElement(array_keys($serviceCategories));
        $serviceName = $this->faker->randomElement($serviceCategories[$category]);

        return [
            'name' => $serviceName,
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->randomFloat(2, 10, 150),
            'service_category_id' => ServiceCategory::where('name', $category)->firstOrFail()->id,
        ];
    }
}
