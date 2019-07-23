<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\File;
use Faker\Generator as Faker;

$factory->define(File::class, function (Faker $faker) {
    return [
        'name'=>$faker->name,
        'file'=>"test-path-check-fileFactory",
        'description'=>$faker->realText(60),
//        'status'=>$faker->randomElement(['active','pasive']),
        'created_by'=>1



    ];
});
