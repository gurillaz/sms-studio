<?php

use App\Client;
use App\Offer;
use Illuminate\Database\Seeder;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $clients = Client::all();
        $offers = Offer::all();
        factory('App\Job',20)->make()->each(function ($job) use ($clients,$offers){

            $job->client_id = $clients->random()->id;
            $job->offer_id = $offers->random()->id;
            $job->save();
            return $job;
        });
    }
}
