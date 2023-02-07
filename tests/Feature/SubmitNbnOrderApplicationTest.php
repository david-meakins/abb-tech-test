<?php

namespace Tests\Feature;

use App\Jobs\SubmitNbnOrderApplication;
use App\Models\Plan;
use App\Models\Application;
use App\Enums\ApplicationStatus;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class SubmitNbnOrderApplicationTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->application = Application::factory()
            ->state([
                'status' => ApplicationStatus::Order
            ])
            ->for(Plan::factory()->state([
                'type' => 'nbn',
            ]))
            ->create();
    }

    /**
     * Test that an NBN order is updated correctly when the response is successful
     *
     * @return void
     */
    public function test_nbn_order_success_response()
    {
        $successResponse = file_get_contents('./tests/stubs/nbn-successful-response.json');
        Http::fake([
            '*' => Http::response($successResponse),
        ]);

        $submitJob = new SubmitNbnOrderApplication($this->application);
        $submitJob->handle();

        $updatedApplication = Application::findOrFail($this->application->id);
        $this->assertEquals('ORD000000000000', $updatedApplication->order_id);
        $this->assertEquals(ApplicationStatus::Complete, $updatedApplication->status);
    }

    /**
     * Test that an NBN order is updated correctly when the response is failure
     *
     * @return void
     */
    public function test_nbn_order_fail_response()
    {
        $failResponse = file_get_contents('./tests/stubs/nbn-fail-response.json');
        Http::fake([
            '*' => Http::response($failResponse),
        ]);

        $sumbitJob = new SubmitNbnOrderApplication($this->application);
        $sumbitJob->handle();

        $updatedApplication = Application::findOrFail($this->application->id);
        $this->assertNull($updatedApplication->order_id);
        $this->assertEquals(ApplicationStatus::OrderFailed, $updatedApplication->status);
    }

    /**
     * Test that an NBN order is updated correctly when the response is failure
     *
     * @return void
     */
    public function test_nbn_order_sends_correct_data()
    {
        $successResponse = file_get_contents('./tests/stubs/nbn-successful-response.json');
        Http::fake([
            '*' => Http::response($successResponse),
        ]);

        $sumbitJob = new SubmitNbnOrderApplication($this->application);
        $sumbitJob->handle();

        Http::assertSent(function (Request $request) {
            return $request->url() == env('NBN_B2B_ENDPOINT') &&
                $request['address_1'] == $this->application->address_1 &&
                $request['address_2'] == $this->application->address_2 &&
                $request['city'] == $this->application->city &&
                $request['state'] == $this->application->state &&
                $request['postcode'] == $this->application->postcode &&
                $request['plan_name'] == $this->application->plan->name;
        });
    }
}
