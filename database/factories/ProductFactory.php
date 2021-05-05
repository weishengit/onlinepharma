<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->realText(15),
            'category_id' => $this->faker->numberBetween(2, 8),
            'tax_id' => 3,
            'generic_name' => $this->faker->lastName,
            'drug_class' => $this->faker->citySuffix,
            'description' => $this->faker->realText(40),
            'price' => $this->faker->randomFloat(2, 5, 200),
            'measurement' => $this->faker->numberBetween(5, 1000) . $this->faker->randomElement($array = array('mg', 'ml', 'g')),
            'critical_level' => $this->faker->numberBetween(200, 400),
            'is_prescription' => $this->faker->numberBetween(0, 1),
            'is_available' => 1,
            'is_active' => 1,
            'image' => 'product_0' . $this->faker->numberBetween(1, 5) . '.png',
        ];
    }
}
