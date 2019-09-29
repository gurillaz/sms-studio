<?php

use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names = ['Inqizim','Fotografim','Iqizim/Dron','AsistimTeknik','Vozitje'];

        foreach ($names as $name){
            factory('App\Task')->create([
                'name'=> $name
            ]);
        }
    }
}
