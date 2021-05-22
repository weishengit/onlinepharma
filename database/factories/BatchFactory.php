<?php

namespace Database\Factories;

use App\Models\Batch;
use Illuminate\Database\Eloquent\Factories\Factory;

class BatchFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Batch::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'batch_no' => $this->faker->uuid,
            'product_id' => $this->faker->numberBetween(1, 50),
            'unit_cost' => $this->faker->numberBetween(5, 200),
            'initial_quantity' => $this->faker->numberBetween(500, 1000),
            'remaining_quantity' => $this->faker->numberBetween(200, 500),
            'expiration' => $this->faker->dateTimeBetween('+1 years', '+3 years', null)
        ];
    }
}
