<?php

namespace Database\Factories;

use App\Models\Contract;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'age' => rand(16, 70),
            'start_date' => $this->faker->date(),
            // When we have a foreign ID, we use the factory responsible for the relation
            // to create the relationship
            'contract_id' => Contract::factory()
        ];
    }
}
