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

            $admin->name = "Klevis Sahitaj";
            $admin->personal_id = "1232129995";
            $admin->phone = "0038349882677";
            $admin->address = "Sopije Suhareke";
            $admin->position = "Manager";
            $admin->salary_type = "month mhhb";
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
        factory('App\User', 5)->create(['role' => 'admin']);
        factory('App\User', 10)->create(['role' => 'employee']);



        factory('App\Inventory', 40)->create(['status' => 'active']);
        factory('App\Inventory', 5)->create(['status' => 'pasive']);

        factory('App\Task', 15)->create(['status' => 'template']);
        // factory('App\Task',25)->create()
        // ->each(function($task){$task->status='finished';$task->rating = rand(0,5); $task->save();});
        // factory('App\Task',10)->create(['status'=>'pending']);
        // factory('App\Task',10)->create(['status'=>'refuesed']);



        factory('App\Service', 30)->create(['status' => 'active']);
        factory('App\Service', 5)->create(['status' => 'pasive']);


        factory('App\Offer', 8)->create(['status' => 'active']);
        factory('App\Offer', 3)->create(['status' => 'pasive']);



        $inventory = Inventory::all();

        $tasks = Task::where('status', 'template')->get();

        foreach ($tasks as $task) {
            $task->inventory()->saveMany($inventory->random(rand(1, 10)));
        }

        $services = Service::all();

        foreach ($services as $service) {
            $service->tasks()->saveMany($tasks->random(rand(2, 10)));
        }

        $offers = Offer::all();

        foreach ($offers as $offer) {
            $offer->services()->saveMany($services->random(rand(1, 10)));
        }




        factory('App\Client', 20)->create();

        $clients = Client::all();


        $employees = User::all();
        $faker = Faker\Factory::create();
        factory('App\Job', 25)->make()
            ->each(function ($job) use ($clients, $offers,$faker,$employees) {
                $job->client_id = $clients->random()->id;
                $job->offer_id = $offers->random()->id;
                $job->status = 'finished';

                $job->save();


                $offer_tasks = [];
                // $tasks = Task::where('service_id',)
                foreach ($job->offer->services as $service) {
                    foreach ($service->tasks as $task) {
                        array_push($offer_tasks, $task);
                    }
                }
                $date = $faker->dateTimeBetween('- 90 days','now');
                factory('App\Event', random_int(1, 5))->create([
                    'job_id' => $job->id,
                    'date_start' => $date,
                    'date_end' => Carbon::parse($date)->addHour(random_int(1, 7))
                ]);
                $job_events = $job->events;
                // return $offer_tasks;
                foreach ($offer_tasks as $task) {
                    $task_clone = $task->replicate();
                    $task_clone->job_id = $job->id;
                    $task_clone->status = 'finished';
                    $task_clone->employee_id = $employees->random()->id;
                    $task_clone->event_id = $job_events->random()->id;
                    $task_clone->rating = random_int(1,5);
                    $task_clone->save();
                    $task_clone->inventory()->sync($task->inventory);
                }
            });
        factory('App\Job', 30)->make()
            ->each(function ($job) use ($clients, $offers,$faker,$employees) {
                $job->client_id = $clients->random()->id;
                $job->offer_id = $offers->random()->id;
                $job->status = 'active';

                $job->save();


                $offer_tasks = [];
                // $tasks = Task::where('service_id',)
                foreach ($job->offer->services as $service) {
                    foreach ($service->tasks as $task) {
                        array_push($offer_tasks, $task);
                    }
                }
                $date = $faker->dateTimeBetween('now','+ 90 days');
                factory('App\Event', random_int(1, 5))->create([
                    'job_id' => $job->id,
                    'date_start' => $date,
                    'date_end' => Carbon::parse($date)->addHour(random_int(1, 7))
                ]);
                $job_events = $job->events;
                // return $offer_tasks;
                foreach ($offer_tasks as $task) {
                    $task_clone = $task->replicate();
                    $task_clone->job_id = $job->id;
                    $task_clone->status = $faker->randomElement(['accepted','refused','pending']);
                    $task_clone->employee_id = $employees->random()->id;
                    $task_clone->event_id = $job_events->random()->id;
                    $task_clone->save();
                    $task_clone->inventory()->sync($task->inventory);
                }
            });


    }
}
