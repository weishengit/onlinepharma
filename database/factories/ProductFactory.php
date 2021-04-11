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
            'name' => $this->faker->unique()->streetSuffix,
            'category_id' => $this->faker->numberBetween(2, 8),
            'tax_id' => $this->faker->numberBetween(2, 5),
            'generic_name' => $this->faker->lastName,
            'drug_class' => $this->faker->citySuffix,
            'description' => $this->faker->realText(140),
            'price' => $this->faker->randomFloat(2, 5, 200),
            'measurement' => $this->faker->numberBetween(5, 1000) . $this->faker->randomElement($array = array('mg', 'ml', 'g')),
            'stock' => $this->faker->numberBetween(1000, 10000),
            'is_prescription' => $this->faker->numberBetween(0, 1),
            'is_available' => 1,
            'is_active' => 1,
            'image' => 'product_0' . $this->faker->numberBetween(1, 5) . '.png',
        ];
    }
}
