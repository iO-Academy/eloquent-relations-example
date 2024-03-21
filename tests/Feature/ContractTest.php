<?php

namespace Tests\Feature;

use App\Models\Contract;
use App\Models\Employee;
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

        // Using a factory returns a model that we can use to change/access the test record
        $contract = Contract::factory()->count(4)->create();

        // We can use this technique to finely tune the test data we have
        // We could write a test now to search contracts, and we know exactly what results we should get back

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

    public function test_getSingleContract(): void
    {
        Employee::factory()->create();

        $response = $this->getJson('/api/contracts/1');

        $response->assertOk()
            ->assertJson(function (AssertableJson $json) { // Looking at the JSON from the top level
                $json->hasAll(['message', 'data'])
                    ->whereType('message', 'string')
                    // This time has does not have a number because for this endpoint
                    // data contains an object not an array
                    ->has('data', function (AssertableJson $json) { // Zooming into the data
                         $json->hasAll(['id', 'name', 'employees'])
                             ->whereAllType([
                                 'id' => 'integer',
                                 'name' => 'string'
                             ])
                             ->has('employees', 1, function(AssertableJson $json) { // Zooming into each employee
                                $json->hasAll(['id', 'name'])
                                    ->whereAllType([
                                        'id' => 'integer',
                                        'name' => 'string'
                                    ]);
                             });
                    });
            });
    }

    public function test_updateContract_invalidData(): void
    {
        // Because we are updating a contract, we need to use the factory to give us a contract to update
        Contract::factory()->create();
        $response = $this->putJson('/api/contracts/1', []);

        $response->assertInvalid(['name']);
    }

    public function test_updateContract_success(): void
    {
        Contract::factory()->create();
        $response = $this->putJson('/api/contracts/1', [
            'name' => 'testing'
        ]);

        $response->assertOk()
            ->assertJson(function (AssertableJson $json) {
               $json->hasAll(['message'])
                ->whereType('message', 'string');
            });

        $this->assertDatabaseHas('contracts', [
            'name' => 'testing'
        ]);
    }

    public function test_updateContract_notFound(): void
    {
        $response = $this->putJson('/api/contracts/1', [
            'name' => 'testing'
        ]);

        $response->assertStatus(404)
            ->assertJson(function (AssertableJson $json) {
                $json->hasAll(['message'])
                    ->whereType('message', 'string');
            });
    }

    public function test_deleteContract_success(): void
    {
        $contract = Contract::factory()->create();

        $response = $this->deleteJson('/api/contracts/1');

        $response->assertOk()
            ->assertJson(function (AssertableJson $json) {
               $json->hasAll(['message'])
                    ->whereType('message', 'string');
            });

        $this->assertDatabaseMissing('contracts', [
            'name' => $contract->name
        ]);
    }
}
