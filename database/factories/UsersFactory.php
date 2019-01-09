<?php

use Illuminate\Support\Facades\Hash;

/*
  |--------------------------------------------------------------------------
  | Model Factories
  |--------------------------------------------------------------------------
  |
  | Here you may define all of your model factories. Model factories give
  | you a convenient way to create models for testing and seeding your
  | database. Just tell the factory how a default model should look.
  |
 */

$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    return [
        'full_name' => $faker->name,
        'email' => $faker->email,
        'black_listed' => $faker->numberBetween(0, 1), //2147483647
        'flatpassword' => 'secreta',
        'password' => Hash::make('secreta'),
        'password_changed' => $faker->dateTime,
        'disabled' => $faker->numberBetween(0, 1),
        'api_token' => str_random(36),
        'remember_token' => str_random(100),
    ];
});
