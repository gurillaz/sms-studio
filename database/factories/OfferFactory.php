<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Offer;
use Faker\Generator as Faker;

$factory->define(Offer::class, function (Faker $faker) {
    return [

        'name'=>$faker->name,
        'price'=>$faker->numberBetween(100,500),
        'discount'=>$faker->randomFloat(1,0.1,1),
        'status'=>$faker->randomElement(['active','pasive']),
        'created_by'=>1



    ];
});
