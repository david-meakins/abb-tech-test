<?php

namespace Tests\Feature;

use App\Enums\ApplicationStatus;
use App\Models\Application;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ApplicationControllerTest extends TestCase
{
    /**
     * Test that /api/applications returns JSON in the correct format
     *
     * @return void
     */
    public function test_index_returns_valid_json_struture()
    {
        $response = $this->getJson('/api/applications');

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'customer_full_name',
                        'address_1',
                        'address_2',
                        'city',
                        'state',
                        'postcode',
                        'plan_type',
                        'plan_name',
                        'plan_monthly_cost',
                    ]
                ],
                'links',
                'meta',
            ]);
    }

    /**
     * Test that when an Order status is not that an Order id is not returned
     *
     * @return void
     */
    public function test_order_id_is_not_set_for_uncompleted_orders()
    {
        Application::factory()->create([
            'status' => ApplicationStatus::PaymentRequired,
        ]);

        $response = $this->getJson('/api/applications');
        $response->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) =>
                $json->has('data', 1, fn ($json) =>
                    $json->hasAll([
                        'id',
                        'customer_full_name',
                        'address_1',
                        'address_2',
                        'city',
                        'state',
                        'postcode',
                        'plan_type',
                        'plan_name',
                        'plan_monthly_cost',
                    ])
                    ->missing('order_id')
                )
                ->etc()
            );
    }

    /**
     * Test that when an Order status is completed that an Order id is returned
     *
     * @return void
     */
    public function test_order_id_is_set_for_completed_orders()
    {
        $application = Application::factory()->create([
            'status' => ApplicationStatus::Complete,
        ]);

        $response = $this->getJson('/api/applications');
        $response->assertStatus(200)
            ->assertJsonPath('data.0.order_id', $application->order_id)
            ->assertJson(fn (AssertableJson $json) =>
                $json->has('data', 1, fn ($json) =>
                    $json->hasAll([
                        'id',
                        'customer_full_name',
                        'address_1',
                        'address_2',
                        'city',
                        'state',
                        'postcode',
                        'plan_type',
                        'plan_name',
                        'plan_monthly_cost',
                        'order_id',
                    ])
                )
                ->etc()
            );
    }
}
