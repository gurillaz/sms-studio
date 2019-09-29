<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Payment;
use Faker\Generator as Faker;

$factory->define(Payment::class, function (Faker $faker) {
    return [
        'name'=>$faker->name,
        'type'=>$faker->randomElement(['in','out']),
        'amount'=>$faker->randomFloat(2,30,1500),
        'from'=>$faker->name,
        'to'=>$faker->company,
        'category'=>$faker->firstName(),
        'description'=>$faker->realText(70),
        'status'=>$faker->randomElement(['active','pasive']),
        'created_by'=>1
    ];
});
