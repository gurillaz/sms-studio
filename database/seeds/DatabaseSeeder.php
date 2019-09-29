<?php

use App\Job;
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
        if (\App\User::query()->where('id', '1')->first()) {

        } else {
            $admin = new \App\User();

            $admin->name = "Klevis Sahitaj";
            $admin->personal_id = "1232129995";
            $admin->phone = "0038349882677";
            $admin->address = "Sopije Suhareke";
            $admin->position = "Manager";
            $admin->salary_type = "monthly";
            $admin->salary_amount = "1342";
            $admin->status = "active";
            $admin->email = "klevissahitaj@gmail.com";
            $admin->email_verified_at = now();
            $admin->password = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi';

            $admin->employee_type = "employee";
            $admin->role = "admin";
            $admin->created_by = 1;

            $admin->save();


        }

////        Service=>Offer=>Task=>Inventory
//        factory('App\Offer',4)->create()->each(function ($offer){
//
//
//            $offer->services()->save(factory('App\Service',3)->create()->each(function ($service){
//                $service->tasks()->save(factory('App\Task',4)->create()->each(function ($task){
//                    $task->inventory()->save(factory('App\Inventory',5)->create());
//                }));
//
//            }));
//
//        });


        $this->call(InventorySeeder::class);
        $this->call(ServiceSeeder::class);
        $this->call(OfferSeeder::class);
        $this->call(TaskSeeder::class);




        $inventory = \App\Inventory::all();
        $tasks = \App\Task::all();
        $services = \App\Service::all();
        $offers = \App\Offer::all();


        foreach ($tasks as $task) {
            $task->inventory()->save($inventory->random());
            $task->inventory()->save($inventory->random());
            $task->inventory()->save($inventory->random());
            $task->inventory()->save($inventory->random());
        }


        foreach ($services as $service) {
            $service->tasks()->save($tasks->random());
            $service->tasks()->save($tasks->random());
            $service->tasks()->save($tasks->random());
            $service->tasks()->save($tasks->random());
            $service->tasks()->save($tasks->random());
            $service->tasks()->save($tasks->random());
            $service->tasks()->save($tasks->random());
        }


        foreach ($offers as $offer) {
            $offer->services()->save($services->random());
            $offer->services()->save($services->random());
            $offer->services()->save($services->random());
            $offer->services()->save($services->random());
            $offer->services()->save($services->random());
            $offer->services()->save($services->random());
            $offer->services()->save($services->random());
        }



         $this->call(ClientSeeder::class);
         $this->call(JobSeeder::class);



         
//         $this->call(UserSeeder::class);
//        factory('App\User',10)->create();
//  
//
//
//        factory('App\Inventory',10)->create();

    }


}
