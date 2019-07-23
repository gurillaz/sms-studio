<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Event;
use Faker\Generator as Faker;

$factory->define(Event::class, function (Faker $faker) {

    $date=$faker->dateTimeThisYear;
    return [

        'name'=>$faker->name,
        'address'=>$faker->address,
        'date_start'=>$date,
        'date_end'=>\Carbon\Carbon::parse($date)->addHour($faker->biasedNumberBetween(3,7)),
        'description'=>$faker->realText(150),

        'status'=>$faker->randomElement(['active','pasive']),
        'created_by'=>1

    ];
});
