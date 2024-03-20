<?php

namespace Tests\Feature;

use App\Models\Contract;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ContractTest extends TestCase
{
    // Tells laravel to run the migrations to give the test database structure
    use DatabaseMigrations;

    /**
     * A basic feature test example.
     */
    public function test_getContracts(): void
    {
        // Use the factory we created to create a single contract in the test database
        Contract::factory()->count(4)->create();

        // We send a get request for JSON to the route we are testing
        // And we store the response in a variable
        $response = $this->getJson('/api/contracts');

        // Now we use the response to make assertions about what we got back from the get request
        // assertStatus makes sure the response has the right status code
        // assertJson allows us to make sure the response has the right json data
        $response->assertStatus(200)
            ->assertJson(function (AssertableJson $json) {
                // In this function we can use $json to assert the structure of the JSON data we got back
                // hasAll allows us to assert that the response has the correct fields
                $json->hasAll(['message', 'data'])
                    // Using whereType to assert that the message is a string
                    // No need to do data here because ->has('data', 4) asserts that it is an array with 4 items
                    ->whereType('message', 'string')
                    // Using has to assert that data contains exactly 1 record (because we only made 1 contract)
                    // here we have used ->has() to 'zoom in' on the JSON contained within the data field
                    ->has('data', 4, function (AssertableJson $json) {
                        // In this callback we have scoped the json to be within data
                        $json->hasAll(['id', 'name'])
                            ->whereAllType([
                                'id' => 'integer',
                                'name' => 'string'
                            ]);
                    });
            });
    }
}
