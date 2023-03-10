<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Account>
 */
class AccountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->create()->id,
            'first_name' => $this->faker->firstName(),
            'last_name'=> $this->faker->lastName(),
            'contact_num'=> $this->faker->phoneNumber(),
            'address'=> $this->faker->address(),
            'profile_image'=>$this->faker->imageUrl(),
        ];
    }
}
