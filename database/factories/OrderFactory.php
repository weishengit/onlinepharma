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
            'user_id' => $this->faker->numberBetween(1, 20),
            'ref_no' => uniqid(),
            'status' => $this->faker->randomElement($array = array ('new','pending', 'dispatched', 'complete', 'cancelled')),
            'is_void' => 0,
            'is_sc' => 0,
            'contact' => '09750239310',
            'delivery_mode' => $this->faker->randomElement($array = array ('delivery','pickup')),
            'total_items' => $this->faker->numberBetween(3, 20),
            'amount_due' => $this->faker->numberBetween(50, 2000),
            'created_at' => $this->faker->dateTimeBetween('-3 years', 'now'),
        ];
    }
}
