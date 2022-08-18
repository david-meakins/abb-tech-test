<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\Customer;
use App\Models\Plan;
use App\Models\User;
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
        User::factory(10)->create();

        $plans = Plan::factory(5)->create();
        $customers = Customer::factory(100)->create();
        foreach ($customers as $customer) {
            Application::factory()->create([
                'customer_id' => $customer->id,
                'plan_id' => $plans->random()->id,
            ]);
        }
    }
}
