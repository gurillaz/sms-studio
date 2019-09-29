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
        $names = ['Oferta 1','Oferta 2','Offerta 3','Offerta 4'];

        foreach ($names as $name){
            factory('App\Offer')->create([
                'name'=> $name
            ]);
        }

    }
}
