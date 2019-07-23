<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Note;
use Faker\Generator as Faker;

$factory->define(Note::class, function (Faker $faker) {
    return [
        'name'=>$faker->name,
        'body'=>$faker->realText(200),
        'status'=>$faker->randomElement(['active','pasive']),
        'created_by'=>1


    ];
});
