<?php

namespace App\Jobs;

use App\Enums\ApplicationStatus;
use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessNbnOrderApplications implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    // Let's be kind of strict here and only allow one attempt
    public $tries = 1;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Get all the Applications that match our criteria for being ready to process
        $applications = Application::planType('nbn')
            ->where('status', '=', ApplicationStatus::Order)
            ->get();

        // These are queued as separate jobs so that we can process them individually and not block the entire pickup
        // process. Ideally we would use an 'intermediate' status of some sort to avoid any still pending jobs being
        // picked up by the next run of this job
        foreach ($applications as $application) {
            SubmitNbnOrderApplication::dispatch($application->id);
        }
    }
}
