<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $password = '12345678';
        if(User::count() == 0)
        {
            return [
                'is_admin' => true,
                'email' => $this->faker->unique()->safeEmail(),
                'password' => Hash::make($password), // password
            ];
        }
        else{
            return [
                'is_admin' => false,
                'email' => $this->faker->unique()->safeEmail(),
                'password' => Hash::make($password), // password
            ];
        }
        
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
