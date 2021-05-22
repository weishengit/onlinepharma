<?php

namespace Database\Factories;

use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Item::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'order_id' => $this->faker->numberBetween(1, 50),
            'quantity' => $this->faker->numberBetween(1, 30),
            'product_id' => $this->faker->numberBetween(1, 50),
            'name' => $this->faker->unique->streetSuffix,
            'description' => $this->faker->realText(140),
            'price' => $this->faker->numberBetween(20, 100),
            'total_price' => $this->faker->randomFloat(2, 5, 200),
            'vat_type' => $this->faker->numberBetween(2, 4),
            'is_prescription' => $this->faker->biasedNumberBetween($min = 0, $max = 1, $function = 'sqrt')
        ];
    }
}
