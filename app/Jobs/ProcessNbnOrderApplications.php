<?php

namespace App\Jobs;

use App\Enums\ApplicationStatus;
use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessNbnOrderApplications implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    // Let's be kind of strict here and only allow one attempt
    public int $tries = 1;

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Get all the Applications that match our criteria for being ready to process
        $applications = Application::hasPlanType('nbn')
            ->where('status', '=', ApplicationStatus::Order)
            ->get();

        // These are queued as separate jobs so that we can process them individually and not block the entire pickup
        // process. Ideally we would use an 'intermediate' status of some sort to avoid any still pending jobs being
        // picked up by the next run of this job

        // Updated to just pass the object because we have implemented ShouldBeUnique to handle dupes
        foreach ($applications as $application) {
            SubmitNbnOrderApplication::dispatch($application);
        }
    }
}
