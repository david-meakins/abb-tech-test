<?php

namespace Tests\Feature;

use App\Enums\ApplicationStatus;
use App\Jobs\ProcessNbnOrderApplications;
use App\Jobs\SubmitNbnOrderApplication;
use App\Models\Application;
use App\Models\Plan;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class ProcessNbnOrderApplicationsTest extends TestCase
{
    /**
     * Test an NBN plan with the correct status is picked up for processing
     *
     * @return void
     */
    public function test_nbn_order_is_picked_up()
    {
        Queue::fake();
        Queue::assertNothingPushed();

        Application::factory()
            ->state([
                'status' => ApplicationStatus::Order
            ])
            ->for(Plan::factory()->state([
                'type' => 'nbn',
            ]))
            ->create();

        $processJob = new ProcessNbnOrderApplications();
        $processJob->handle();

        Queue::assertPushed(SubmitNbnOrderApplication::class, 1);
    }

    /**
     * Test an NBN plan with the wrong status is not picked up for processing
     *
     * @return void
     */
    public function test_nbn_order_with_wrong_status_is_not_picked_up()
    {
        Queue::fake();
        Queue::assertNothingPushed();

        Application::factory()->state([
            'status' => ApplicationStatus::Prelim
        ])
            ->for(Plan::factory()->state([
                'type' => 'nbn',
            ]))
            ->create();

        $processJob = new ProcessNbnOrderApplications();
        $processJob->handle();

        Queue::assertNothingPushed();
    }

    /**
     * Test a non-NBN plan is not picked up for processing
     *
     * @return void
     */
    public function test_non_nbn_order_is_not_picked_up()
    {
        Queue::fake();
        Queue::assertNothingPushed();

        Application::factory()->state([
                'status' => ApplicationStatus::Order
            ])
            ->for(Plan::factory()->state([
                'type' => 'mobile',
            ]))
            ->create();

        $processJob = new ProcessNbnOrderApplications();
        $processJob->handle();

        Queue::assertNothingPushed();
    }

}
