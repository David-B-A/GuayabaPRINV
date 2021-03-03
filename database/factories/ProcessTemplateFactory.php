<?php

namespace Database\Factories;

use App\Models\ProcessTemplate;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProcessTemplateFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProcessTemplate::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
        'description' => $this->faker->word,
        'inputs' => $this->faker->word,
        'outputs' => $this->faker->word,
        'metadata' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
