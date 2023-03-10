<?php

namespace Database\Factories;

use App\Models\Item;
use App\Models\JobOrder;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ItemJobOrder>
 */
class ItemJobOrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'job_order_id' => JobOrder::factory()->create()->id,
            'item_id' => $item = Item::factory()->create()->id,
            'quantity' => $quant = random_int(1,100),
            'total_points' => $quant * Item::Where('id','=',$item)->pluck('unit_points')->first(),
        ];
    }
}
