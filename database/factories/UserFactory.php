<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->userName,
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'contact' => '09' . $this->faker->randomNumber(8) . $this->faker->randomDigit,
            'address' => 
                $this->faker->buildingNumber . ' ' .
                $this->faker->streetName . ', ' . 
                'Brgy ' . $this->faker->cityPrefix . ', ' .
                $this->faker->city . ' City',
            'scid' => $this->faker->randomNumber(8),
            'is_active' => $this->faker->biasedNumberBetween(0, 1, $function = 'sqrt'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
