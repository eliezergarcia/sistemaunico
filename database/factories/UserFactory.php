<?php

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

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'user_name' => $faker->unique()->word,
        'email' => $faker->unique()->safeEmail,
        'password' => 'secret', // $2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm
        // 'avatar' => $faker->imageUrl($width = 200, $height = 200),
        'phone' => $faker->tollFreePhoneNumber,
        'address' => $faker->address,
        'email_office' => $faker->unique()->safeEmail,
        'password_email_office' => 'secret',
        'remember_token' => str_random(10),
    ];
});
