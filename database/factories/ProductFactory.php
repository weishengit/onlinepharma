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
            'category_id' => $this->faker->numberBetween(1, 8),
            'generic_name' => $this->faker->lastName,
            'drug_class' => $this->faker->citySuffix,
            'description' => $this->faker->realText(140), 
            'price' => $this->faker->randomFloat(2, 5, 500),
            'measurement' => $this->faker->numberBetween(5, 1000) . $this->faker->randomElement($array = array('mg', 'ml', 'g')),
            'stock' => $this->faker->numberBetween(100, 1000),
            'is_prescription' => $this->faker->numberBetween(0, 1),
            'is_available' => $this->faker->biasedNumberBetween(0, 1, $function = 'sqrt'),
            'is_active' => $this->faker->biasedNumberBetween(0, 1, $function = 'sqrt'),
            'image' => 'product_0' . $this->faker->numberBetween(1, 6) . '.png',
        ];
    }
}
