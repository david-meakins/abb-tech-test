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
use Illuminate\Support\Facades\Http;

class SubmitNbnOrderApplication implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    // Also being strict here and only allowing one attempt
    public int $tries = 1;

    protected Application $application;

    /**
     * Create a new job instance.
     */
    public function __construct($application)
    {
        // I dislike serialising objects into the queue for a couple of reasons. If you've deliberately delayed the
        // processing the object might have changed, and things get difficult to debug if you're trying to read
        // serialised objects directly from the queue. There's certainly a case for it though if you'd rather not have
        // the overhead of the DB load each time.

        // Updated to just set the Application here because we're using the SerializesModels trait
        $this->application = $application;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // In a real app we'd probably work out some sensible timeouts and retries here too in combination with the
        // number of retries this job is allowed. Probably a candidate to DI an NBN request class into this job too,
        // with some enums for success/failure response values but that's out of scope
        $response = Http::post(config('nbn.b2b_endpoint'), [
            'address_1' => $this->application->address_1,
            'address_2' => $this->application->address_2,
            'city' => $this->application->city,
            'state' => $this->application->state,
            'postcode' => $this->application->postcode,
            'plan_name' => $this->application->plan->name,
        ]);

        if ($response->successful() && 'Successful' === $response->json('status')) {
            $this->application->status = ApplicationStatus::Complete;
            $this->application->order_id = $response->json('id');
        } else {
            // We'd be checking for a specific response failure and client/server errors here instead of just
            // "not success" and handle some errors properly, like recording that the endpoint was unavailable or what
            // the error returned actually was
            $this->application->status = ApplicationStatus::OrderFailed;
        }
        $this->application->save();
    }

    /**
     * The unique ID of the job.
     */
    public function uniqueId(): string
    {
        return $this->application->id;
    }

}
