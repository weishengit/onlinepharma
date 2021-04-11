<?php

namespace Database\Factories;

use App\Models\Tax;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaxFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Tax::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // CURRENTLY UNUSED
        return [
            'name' => $this->faker->unique()->domainWord,
            'rate' => 0. . $this->faker->randomNumber(2),
            'is_active' => 1,
        ];
    }
}
