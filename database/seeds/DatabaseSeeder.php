<?php

use App\Client;
use App\Employee;
use App\Inventory;
use App\Job;
use App\Offer;
use App\Service;
use App\Task;
use App\User;
use Illuminate\Database\Seeder;
// use Faker;
use Illuminate\Support\Carbon;

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
        if (User::query()->where('id', '1')->first()) { } else {
            $admin = new User();

            $admin->name = "John Doe";
            $admin->personal_id = "111111111";
            $admin->phone = "0012345678908";
            $admin->address = "Backer Street";
            $admin->position = "Detective";
            $admin->salary_type = "month mhhb";
            $admin->salary_amount = "1342";
            $admin->status = "active";
            $admin->email = "admin@gmail.com";
            $admin->email_verified_at = now();
            $admin->password = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi';

            $admin->employee_type = "employee";
            $admin->role = "admin";
            $admin->created_by = 1;

            $admin->save();
        }
        // factory('App\User', 5)->create(['role' => 'admin']);
        // factory('App\User', 10)->create(['role' => 'employee']);



        // factory('App\Inventory', 20)->create(['status' => 'active']);
        // factory('App\Inventory', 5)->create(['status' => 'pasive']);

        // // factory('App\Task', 15)->create(['status' => 'template']);
        // // // factory('App\Task',25)->create()
        // // // ->each(function($task){$task->status='finished';$task->rating = rand(0,5); $task->save();});
        // // // factory('App\Task',10)->create(['status'=>'pending']);
        // // // factory('App\Task',10)->create(['status'=>'refuesed']);



        // factory('App\Service', 10)->create(['status' => 'active']);
        // factory('App\Service', 5)->create(['status' => 'pasive']);


        // factory('App\Offer', 8)->create(['status' => 'active']);
        // // factory('App\Offer', 3)->create(['status' => 'pasive']);



        // $inventory = Inventory::all();

        // // $tasks = Task::where('status', 'template')->get();

        // // foreach ($tasks as $task) {
        // //     $task->inventory()->saveMany($inventory->random(rand(1, 10)));
        // // }

        // $services = Service::all();

        // // foreach ($services as $service) {
        // //     $service->tasks()->saveMany($tasks->random(rand(2, 10)));
        // // }

        // $offers = Offer::all();

        // foreach ($offers as $offer) {
        //     $offer->services()->saveMany($services->random(rand(1, 10)));
        // }




        // factory('App\Client', 20)->create();

        // $clients = Client::all();


        // $employees = User::all();
        // $faker = Faker\Factory::create();
        // factory('App\Job', 10)->make()
        //     ->each(function ($job) use ($clients, $offers,$faker,$employees,$inventory) {
        //         $job->client_id = $clients->random()->id;
        //         $job->offer_id = $offers->random()->id;
        //         $job->status = 'finished';

        //         $job->save();

        //         $date = $faker->dateTimeBetween('- 90 days','now');
        //         factory('App\Event', random_int(1, 5))->create([
        //             'job_id' => $job->id,
        //             'date_start' => $date,
        //             'status' => 'finished',
        //             'date_end' => Carbon::parse($date)->addHour(random_int(1, 7))
        //         ]);
        //         $job_events = $job->events;
        //         factory('App\Task', 15)->make()
        //         ->each(function($task) use ($job,$job_events,$employees,$inventory){

        //             // $task_clone = $task->replicate();
        //             $task->name = 'Finished TASK';
        //             $task->job_id = $job->id;
        //             $task->status = 'finished';
        //             $task->employee_id = $employees->random()->id;
        //             $task->event_id = $job_events->random()->id;
        //             $task->rating = random_int(1,5);
        //             $task->save();
        //             $task->inventory()->sync($inventory->random(5));
        //         });
        //     });
        // factory('App\Job', 15)->make()
        //     ->each(function ($job) use ($clients, $offers,$faker,$employees,$inventory) {
        //         $job->client_id = $clients->random()->id;
        //         $job->offer_id = $offers->random()->id;
        //         $job->status = 'active';

        //         $job->save();


        //         $date = $faker->dateTimeBetween('now','+ 30 days');
        //         factory('App\Event', random_int(1, 5))->create([
        //             'job_id' => $job->id,
        //             'status' => 'active',
        //             'date_start' => $date,
        //             'date_end' => Carbon::parse($date)->addHour(random_int(1, 7))
        //         ]);

        //         $job_events = $job->events;
        //         factory('App\Task', 15)->make()
        //         ->each(function($task) use ($faker,$job,$job_events,$employees,$inventory){

        //             // $task_clone = $task->replicate();
        //             $task->name = 'Unfished TASK';
        //             $task->job_id = $job->id;
        //             $task->status = $faker->randomElement(['accepted','refused','pending']);
        //             $task->employee_id = $employees->random()->id;
        //             $task->event_id = $job_events->random()->id;
        //             $task->rating = 0;
        //             $task->save();
        //             $task->inventory()->sync($inventory->random(5));
        //         });

        //     });


    }
}
