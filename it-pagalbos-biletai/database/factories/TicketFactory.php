<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
        'workplace_id'=> \App\Models\Workplace::factory(),
        'device_id'=> \App\Models\Device::factory(),
        'status'=>fake()->randomElement(['open','in_progress','resolved']),
        'assigned_specialist'=>fake()->optional()->name(),
        'priority'=>fake()->randomElement(['low','medium','high']),
        'description'=>fake()->sentence(12)
        ];
    }
}
