<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class InventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names = ['camera 1','camera 2','car 1','camera 2','lens 23','lens 22','Battery 2'];

        foreach ($names as $name){
            factory('App\Inventory')->create([
                'name'=> $name
            ]);
        }





    }
}
