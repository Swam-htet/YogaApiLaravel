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
            'day_of_week' => $this->faker->dayOfWeek(),
            // time in format - '10:00'
            'time_of_course' => $this->faker->time('H:i'),
            'capacity' => $this->faker->numberBetween(5, 20),
            'duration' => $this->faker->numberBetween(30, 90),
            'price_per_class' => $this->faker->randomFloat(2, 10, 50),
            'type_of_class' => $this->faker->randomElement(['Hatha', 'Vinyasa', 'Ashtanga', 'Yin', 'Kundalini']),
            'description' => $this->faker->sentence(),
            'location' => $this->faker->address(),
        ];
    }
}
