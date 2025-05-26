<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Office>
 */
class OfficeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    // Schema::create('offices', function (Blueprint $table) {
    //         $table->id();
    //         $table->string('office_number')->unique();
    //         $table->string('office_name');
    //         $table->string('owner_email')->unique();
    //         $table->string('owner_name');
    //         $table->string('owner_phone_number');
    //         $table->integer('vehicle_limit');
    //         $table->enum("status", ['Active', 'Inactive'])->default('Active');
    //         $table->timestamps();
    //         $table->softDeletes();
    //     });
    public function definition(): array
    {
        return [
            //
            'office_number' => $this->faker->unique()->numerify('OFF###'),
            'office_name' => $this->faker->company(),
            'owner_email' => $this->faker->unique()->safeEmail(),
            'owner_name' => $this->faker->name(),
            'owner_phone_number' => $this->faker->phoneNumber(),
            'vehicle_limit' => $this->faker->numberBetween(1, 100),
            'created_at' => now(),
            'updated_at' => now(),
            'deleted_at' => null,
        ];
    }
}
