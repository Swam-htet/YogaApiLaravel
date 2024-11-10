<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\YogaClass>
 */
class YogaClassFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // in format 12/11/2024
            'date' => $this->faker->date('m/d/Y'),
            'teacher' => $this->faker->name(),
            'additional_comments' => $this->faker->sentence(),
        ];
    }
}
