<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApplicationControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_index_returns_valid_json_struture()
    {
        $response = $this->getJson('/api/applications');

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'applications' => [
                    '*' => [
                        'id',
                        'status',
                        'customer_id',
                        'plan_id',
                        'address_1',
                        'address_2',
                        'city',
                        'state',
                        'postcode',
                        'order_id',
                        'created_at',
                        'updated_at',
                    ]
                ]
            ]);
    }
}
