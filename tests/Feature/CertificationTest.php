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
}
