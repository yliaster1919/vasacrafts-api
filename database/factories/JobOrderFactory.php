<?php

namespace Database\Factories;

use App\Models\Client;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JobOrder>
 */
class JobOrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'client_id' => Client::factory()->create()->id,
            'date_release'=> Carbon::now()->subDays(rand(1,14)),
            'contact_num' => $this->faker->phoneNumber(),
            'delivery_address' => $this->faker->address(),
            'pfi_reference_number' => $this->faker->numerify('##-####'),
            'shipment_date' => Carbon::now()->addDays(rand(30,90)),
            'approved_by' => $this->faker->name(),
        ];
    }
}
