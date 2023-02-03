<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Delivery;
use App\Models\Order;
use Carbon\Carbon;
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
        $clients = 300;
        $faker = \Faker\Factory::create();

        for ($i=0; $i<$clients; ++$i) {
            $client = Client::create([
                'name' => $faker->company
            ]);

            $budget = rand(10, 1000);
            $delivered = rand(0, $budget * 1.4);
            $drivers = [];
            for ($d=0; $d<$delivered; ++$d) {
                $drivers[] = [
                    'client_id' => $client->id,
                    'delivery_date' => Carbon::now()->subMinutes(rand(1, 30 * 24 * 30)),
                    'driver_name' => $faker->name
                ];
            }
            Delivery::insert($drivers);

            Order::create([
                'client_id' => $client->id,
                'period_from' => Carbon::today()->subDays(rand(7, 30)),
                'period_to' => Carbon::today()->addDays(rand(1, 10))->endOfDay(),
                'period_app_limit' => $budget,
                'daily_app_limit' => null
            ]);
        }
    }
}
