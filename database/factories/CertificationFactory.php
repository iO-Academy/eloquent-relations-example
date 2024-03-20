<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Certification>
 */

// A factory is simply a class that contains instructions on how to make a faked database record
// We can use these factories in our tests to populate the database with data to test against
// Factories differ from seeders in the following ways:
    // Seeders are used to populate the database with a bunch of generic test data for local dev work
    // Factories are more specific, we can use factories to populate the test database in very specific ways
        // They allow more precise control over what goes into the test database
// Tests can use seeders to populate the database if all you need is a bunch of data
// We can update our seeders to make sure of the factories if we want to
class CertificationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Update the array returned by the definition method to create data for the model
        return [
            'name' => $this->faker->sentence(2),
            'description' => $this->faker->paragraph(5)
        ];
    }
}
