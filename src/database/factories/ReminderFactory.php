<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reminder>
 */
class ReminderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(rand(3, 6)),
            'description' => $this->faker->sentence(15),
            'remind_at' => $this->faker->dateTimeBetween('now', '+1 week'),
            'event_at' => $this->faker->dateTimeBetween('+1 week', '+2 week'),
        ];
    }
}
