<?php

use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory('App\Event',20)->create()->each(function ($event){




            $event->contract()->save(factory('App\File')->make());
            $event->offer()->save(factory('App\Offer')->make());
            $event->offer()->save(factory('App\Offer')->make());
        });
    }
}
