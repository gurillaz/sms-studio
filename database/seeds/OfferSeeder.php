<?php

use Illuminate\Database\Seeder;

class OfferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory('App\Offer',5)->create()->each(function ($offer){

            $offer->services()->save(factory('App\Service')->make());
            $offer->services()->save(factory('App\Service')->make());


            return $offer;
        });
    }
}
