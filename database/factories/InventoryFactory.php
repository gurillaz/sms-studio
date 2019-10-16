<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Inventory;
use Faker\Generator as Faker;

$factory->define(Inventory::class, function (Faker $faker) {
    return [
        'name'=>$faker->colorName,
        'type'=>$faker->name,
        'purchase_date'=>$faker->dateTimeThisYear,
        'supplier'=>$faker->company,
        'price'=>$faker->randomFloat(2,10,999),
        'serial'=>$faker->creditCardNumber,
        'description'=>$faker->realText(100),
        'status'=>$faker->randomElement(['active','pasive']),
        'created_by'=>1

    ];
});
