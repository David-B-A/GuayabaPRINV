<?php

namespace Database\Factories;

use App\Models\Process;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProcessFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Process::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user' => $this->faker->word,
        'responsible' => $this->faker->word,
        'process_template' => $this->faker->word,
        'comments' => $this->faker->word,
        'status' => $this->faker->word,
        'inputs' => $this->faker->word,
        'outputs' => $this->faker->word,
        'metadata' => $this->faker->word,
        'scheduled_date' => $this->faker->word,
        'executed_date' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
