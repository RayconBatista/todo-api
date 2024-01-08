<?php

namespace Database\Factories;

use App\Models\todo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<todo>
 */
class TodoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'label' => $this->faker->sentence(),
            'user_id' => $this->faker->randomNumber(),
            'project_id' => $this->faker->randomNumber(),
        ];
    }
}
