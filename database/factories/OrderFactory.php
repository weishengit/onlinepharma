<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

use function PHPSTORM_META\map;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'prescription_image' => 'product_04.png',
            'scid_image' => 'product_03.png',
            'is_sc' => 1,
            'sc_discount' => 0.20,
            'delivery_mode' => $this->faker->randomElement($array = array ('delivery','pickup')),
            'total_items' => $this->faker->numberBetween(1, 50),
            'subtotal' => $this->faker->numberBetween(50, 2000),
        ];
    }
}
