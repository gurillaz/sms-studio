<?php

use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $events = \App\Event::all()->get('id');


        factory('App\Employee',10)->create()->each(function ($emp){
            $emp->files()->save(factory('App\File')->make());
            $emp->files()->save(factory('App\File')->make());
            $emp->files()->save(factory('App\File')->make());

            $emp->notes()->save(factory('App\Note')->make());
            $emp->notes()->save(factory('App\Note')->make());
            $emp->notes()->save(factory('App\Note')->make());
            $emp->notes()->save(factory('App\Note')->make());
            $emp->notes()->save(factory('App\Note')->make());
            $emp->notes()->save(factory('App\Note')->make());


//            $emp->events()->save(factory('App\Event')->make());
//            $emp->events()->save(factory('App\Event')->make());
//            $emp->events()->save(factory('App\Event')->make());
//            $emp->events()->save(factory('App\Event')->make());
//            $emp->events()->save(factory('App\Event')->make());
//            $emp->events()->save(factory('App\Event')->make());
//            $emp->events()->save(factory('App\Event')->make());



        });
    }
}
