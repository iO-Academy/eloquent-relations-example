<?php

namespace Tests\Feature;

use App\Models\Certification;
use App\Models\Employee;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class EmployeeTest extends TestCase
{

    use DatabaseMigrations;
    /**
     * A basic feature test example.
     */
    public function test_getEmployees(): void
    {
        // When we need test data that has a many to many relationship
        // We use has with the related factory to create it
        Employee::factory()->has(Certification::factory())->create();

        $response = $this->getJson('/api/employees');
        // Started with 74 assertions
        $response->assertStatus(200)
            ->assertJson(function (AssertableJson $json) {
                 $json->hasAll(['message', 'data'])
                     ->whereType('message', 'string')
                     ->has('data', 1, function (AssertableJson $json) {
                         $json->hasAll(['id', 'name', 'age' , 'start_date', 'contract', 'certifications'])
                             ->whereAllType([
                                 'id' => 'integer',
                                 'name' => 'string',
                                 'age' => 'integer',
                                 'start_date' => 'string'
                             ])
                             ->has('contract', function (AssertableJson $json) {
                                 $json->hasAll(['id', 'name'])
                                     ->whereAllType([
                                         'id' => 'integer',
                                         'name' => 'string'
                                     ]);
                             })
                             ->has('certifications', 1, function (AssertableJson $json) {
                                 $json->hasAll(['id', 'name', 'description'])
                                     ->whereAllType([
                                         'id' => 'integer',
                                         'name' => 'string',
                                         'description' => 'string'
                                     ]);
                             });
                     });
            });
    }
}
