<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Device>
 */
class DeviceFactory extends Factory
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
        'type'=>fake()->randomElement(['pc','printer','network','other']),
        'status'=>fake()->randomElement(['active','inactive','maintenance']),
        'serial'=>fake()->bothify('SN-####-????')
        ];
    }
}
