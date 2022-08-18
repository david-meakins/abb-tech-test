<?php

namespace Tests\Feature;

use App\Enums\ApplicationStatus;
use App\Models\Application;
use App\Models\Plan;
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

    /**
     * Test that when we ask for a specific plan type only that type is returned
     *
     * @return void
     */
    public function test_application_by_plan_filter_doesnt_return_other_types()
    {
        // This could also be part of a setup / tear down for this test where we just create
        // one application per plan type instead.

        // Create one 'mobile' application
        Application::factory()
            ->count(1)
            ->for(Plan::factory()->state([
                'type' => 'mobile'
            ]))
            ->create();

        // Create some applications that don't have the 'mobile' plan type
        Application::factory()
            ->count(1)
            ->for(Plan::factory()->state([
                'type' => 'opticomm',
            ]))
            ->create();
        Application::factory()
            ->count(1)
            ->for(Plan::factory()->state([
                'type' => 'nbn',
            ]))
            ->create();

        $response = $this->getJson('/api/applications?plan_type=mobile');
        $response->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.plan_type', 'mobile');
    }

    /**
     * Test that when we ask for a specific plan type only that type is returned
     *
     * @return void
     */
    public function test_application_by_plan_filter_returns_no_results_if_no_matching_types()
    {
        // Create some applications that don't have the 'nbn' type
        Application::factory()
            ->count(1)
            ->for(Plan::factory()->state([
                'type' => 'opticomm',
            ]))
            ->create();
        Application::factory()
            ->count(1)
            ->for(Plan::factory()->state([
                'type' => 'mobile',
            ]))
            ->create();

        $response = $this->getJson('/api/applications?plan_type=nbn');
        $response->assertStatus(200)
            ->assertJsonCount(0, 'data');
    }

    /**
     * See note in ApplicationController about the response
     *
     * @return void
     */
    public function test_application_by_incorrect_plan_filter_does_redirect()
    {
        Application::factory()
            ->count(1)
            ->for(Plan::factory()->state([
                'type' => 'opticomm'
            ]))
            ->create();

        $response = $this->getJson('/api/applications?plan_type=incorrect');
        $response->assertStatus(422);
    }

}
