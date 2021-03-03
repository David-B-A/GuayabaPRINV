<?php

namespace Database\Factories;

use App\Models\Sale;
use Illuminate\Database\Eloquent\Factories\Factory;

class SaleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Sale::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user' => $this->faker->word,
        'customer' => $this->faker->word,
        'products' => $this->faker->word,
        'total' => $this->faker->randomDigitNotNull,
        'cash' => $this->faker->randomDigitNotNull,
        'credit' => $this->faker->randomDigitNotNull,
        'status' => $this->faker->word,
        'payment_status' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
