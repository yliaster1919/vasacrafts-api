<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'item_code' => $this->faker->bothify('??-##'),
            'photo'=>$this->faker->imageUrl(),
            'description' => $this->faker->paragraph(),
            'dimensions'=> $this->faker->numerify('##.# dia x ## H' ),
            'finish'=> $this->faker->word(),
            'unit_points'=> $this->faker->randomFloat(1,2,5,2),
            
        ];
    }
}
