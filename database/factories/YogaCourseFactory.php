<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\YogaCourse>
 */
class YogaCourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'day_of_week' => $this->faker->dayOfWeek,
            'time_of_course' => $this->faker->time(),
            'capacity' => $this->faker->numberBetween(1, 100),
            'duration' => $this->faker->numberBetween(1, 3),
            'price_per_class' => $this->faker->randomFloat(2, 10, 100),
            'type_of_class' => $this->faker->word,
            'description' => $this->faker->sentence,
            'class_mode' => $this->faker->word,
        ];
    }
}
