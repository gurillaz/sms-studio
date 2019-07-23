<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Client;
use Faker\Generator as Faker;

$factory->define(Client::class, function (Faker $faker) {
    return [
        'name'=>$faker->name,
        'phone'=>$faker->phoneNumber,
        'email'=>$faker->email,
        'city'=>$faker->city,
        'address'=>$faker->address,


        'created_by'=>1
    ];
});
