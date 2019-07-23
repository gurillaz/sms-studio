<?php

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
        // $this->call(UsersTableSeeder::class);
        if(\App\User::query()->where('id','1')->first()){

        }
        else{
            factory(\App\User::class)->create();

        }

        $this->call(OfferSeeder::class);
        $this->call(EmployeeSeeder::class);
        $this->call(ClientSeeder::class);
    }
}
