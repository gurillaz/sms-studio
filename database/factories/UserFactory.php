<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\User;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'name'=>$faker->name,
        'personal_id'=>$faker->uuid,


        'phone'=>$faker->phoneNumber,
        'address'=>$faker->address,
        'position'=>$faker->jobTitle,
        'salary_type'=>$faker->randomElement(['hour','day','month']),

        'salary_amount'=>$faker->randomFloat(2,200,600),
        'status'=>$faker->randomElement(['active','pasive']),

        'email' => $faker->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),


        'employee_type'=>$faker->randomElement(['employee','contractor']),
        'role'=>$faker->randomElement(['employee','admin']),

        'created_by'=>1


//        'name' => "Klevis Sahitaj",
//        'email' => "klevissahitaj@gmail.com",
//        'email_verified_at' => now(),
//        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
//        'remember_token' => Str::random(10),
    ];
});
