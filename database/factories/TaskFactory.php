<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Task;
use Faker\Generator as Faker;

$factory->define(Task::class, function (Faker $faker) {

    return [
        'name'=>$faker->name,

        'description'=>$faker->realText(150),
        'payment_sum'=>$faker->numberBetween(10,100),

        'status'=>$faker->randomElement(['pending','finished','refused','accepted']),




        'created_by'=>1
    ];
});
