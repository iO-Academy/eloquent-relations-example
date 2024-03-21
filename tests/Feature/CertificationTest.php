<?php

namespace Tests\Feature;

use App\Models\Certification;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class CertificationTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     */
    public function test_getCertifications(): void
    {
        // Use the factory to create test data
        Certification::factory()->count(3)->create();

        $response = $this->getJson('/api/certifications');

        $response->assertStatus(200)
            ->assertJson(function (AssertableJson $json) {
                $json->hasAll(['message', 'data'])
                    ->whereType('message', 'string')
                    ->has('data', 3, function (AssertableJson $json) {
                        $json->hasAll(['id', 'name', 'description'])
                            ->whereAllType([
                                'id' => 'integer',
                                'name' => 'string',
                                'description' => 'string'
                            ]);
                    });
            });
    }

    public function test_createCertification_invalidData(): void
    {
        // To send a POST request we use postJson
        // To add data to the request (just like the body in Postman) we pass in an
        // assoc array as the second argument
        $response = $this->postJson('/api/certifications', []);

        // WHen testing validation we can use assertInvalid which does the following things:
        // Checks to make sure the status is 422
        // Checks to make sure that response contains validation errors for the given fields (name and description)
        $response->assertInvalid(['name', 'description']);
    }

    public function test_createCertification_success(): void
    {
        $response = $this->postJson('/api/certifications', [
            'name' => 'Testing',
            'description' => 'Testing'
        ]);

        $response->assertStatus(201)
            ->assertJson(function (AssertableJson $json) {
                $json->hasAll(['message'])
                    ->whereType('message', 'string');
            });

        // AssertDatabaseHas takes two arguments
        // The name of the database table you want to check
        // And the data that should now be found in that table
        $this->assertDatabaseHas('certifications', [
            'name' => 'Testing',
            'description' => 'Testing'
        ]);
    }

}
