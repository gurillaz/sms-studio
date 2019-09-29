<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Job;
use Faker\Generator as Faker;

$factory->define(Job::class, function (Faker $faker) {
    return [


        'name'=>$faker->name,

        'description'=>$faker->realText(150),
        'price'=>$faker->numberBetween(10,1000),
        'payment_status'=>$faker->randomElement(['paid','unpaid','partiallyPaid']),

        'status'=>$faker->randomElement(['active','finished','cancelled']),




        'created_by'=>1
    ];
});
