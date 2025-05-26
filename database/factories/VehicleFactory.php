<?php

namespace Database\Factories;

use App\Models\Office;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vehicle>
 */
class VehicleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'vehicle_number' => $this->faker->unique()->regexify('[A-Z]{2}[0-9]{4}'),
            'owner_phone' => $this->faker->phoneNumber,
            'office_id' => Office::factory(),
            'check_in_status' => $this->faker->randomElement(['Parked', 'Not Parked']),
            'check_in_time' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'check_out_time' => $this->faker->dateTimeBetween('now', '+1 month'),
        ];
    }
}
