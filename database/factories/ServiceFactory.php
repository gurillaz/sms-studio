<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Service;
use Faker\Generator as Faker;

$factory->define(Service::class, function (Faker $faker) {
    return [
        'name'=>$faker->name,
        'price'=>$faker->numberBetween(100,500),
        'description'=>$faker->realText(100),
        'status'=>$faker->randomElement(['active','pasive']),
        'created_by'=>1

    ];
});
