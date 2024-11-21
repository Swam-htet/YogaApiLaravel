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
            'date' => $this->faker->date('Y-m-d'),
            'teacher' => $this->faker->name(),
            'additional_comments' => $this->faker->sentence(),
        ];
    }
}
