<?php

namespace Database\Factories;

use App\Models\Pet;
use App\Models\PetType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker; // Inject Faker

class PetFactory extends Factory
{
    protected $model = Pet::class;

    public function definition()
    {
        $breeds = [
            'Dog' => ['Golden Retriever', 'German Shepherd', 'Labrador Retriever'],
            'Cat' => ['Siamese', 'Maine Coon', 'Persian'],
            'Hamster' => ['Syrian Hamster', 'Dwarf Hamster', 'Chinese Hamster'],
            'Bunny' => ['Holland Lop', 'Mini Rex', 'Dutch Rabbit'],
            'Fish' => ['Goldfish', 'Betta Fish', 'Guppy'],
            'Turtle' => ['Red-Eared Slider', 'Painted Turtle', 'Box Turtle'],
        ];

        $type = $this->faker->randomElement(array_keys($breeds));
        $breed = $this->faker->randomElement($breeds[$type]);

        return [
            'name' => $this->faker->name,
            'description' => $this->faker->paragraph(),
            'age' => $this->faker->numberBetween(1, 15),
            'breed' => $breed,
            'pet_type_id' => PetType::all()->random()->id, // Efficient random selection
        ];
    }
}
