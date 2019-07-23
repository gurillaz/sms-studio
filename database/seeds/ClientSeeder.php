<?php

use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory('App\Client',10)->create()->each(function ($client){
            $client->files()->save(factory('App\File')->make());
            $client->files()->save(factory('App\File')->make());
            $client->files()->save(factory('App\File')->make());

            $client->notes()->save(factory('App\Note')->make());
            $client->notes()->save(factory('App\Note')->make());
            $client->notes()->save(factory('App\Note')->make());
            $client->notes()->save(factory('App\Note')->make());
            $client->notes()->save(factory('App\Note')->make());
            $client->notes()->save(factory('App\Note')->make());


            $client->events()->save(factory('App\Event')->make());
            $client->events()->save(factory('App\Event')->make());
            $client->events()->save(factory('App\Event')->make());
            $client->events()->save(factory('App\Event')->make());
            $client->events()->save(factory('App\Event')->make());
            $client->events()->save(factory('App\Event')->make());
            $client->events()->save(factory('App\Event')->make());


            return $client;
        });
    }
}
