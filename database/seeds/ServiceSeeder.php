<?php

use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names = ['Inqizim','Shatorr','Fotografi','Printim i fotove','Inqizim me kran'];

        foreach ($names as $name){
            factory('App\Service')->create([
                'name'=> $name
            ]);
        }

    }
}
