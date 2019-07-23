<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Employee;
use Faker\Generator as Faker;

$factory->define(Employee::class, function (Faker $faker) {
    return [
        'name'=>$faker->name,
        'phone'=>$faker->phoneNumber,
        'address'=>$faker->address,
        'position'=>$faker->jobTitle,
        'salary_type'=>$faker->randomElement(['hour','day','month']),

        'salary_amount'=>$faker->randomFloat(2,200,600),
        'status'=>$faker->randomElement(['active','pasive']),
        'created_by'=>1
    ];
});
