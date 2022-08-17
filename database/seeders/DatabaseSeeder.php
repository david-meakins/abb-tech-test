<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\Plan;
use App\Models\User;
use Database\Factories\CustomerFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $users = User::factory(10)->create();
        $plans = Plan::factory(5)->create();
        $customers = Customer::factory(100)->create()->shuffle();
        foreach ($customers as $customer) {
            $application = Application::factory()->create();
            $application->plan = $plans->random();
            $application->customer = $customer;
        }
    }
}
