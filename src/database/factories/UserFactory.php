<?php

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory as EloquentFactory;

/** @var EloquentFactory $factory */
$factory->define(User::class, function (Faker $faker) {
    return [
        'login'          => $faker->unique()->userName,
        'display_name'   => $faker->unique()->name,
        'email'          => $faker->unique()->email,
        'password'       => 'secret',
        'remember_token' => Str::random(10),
        'deleted_at'     => $faker->randomElement([null, null, null, Carbon::now()]),
    ];
});
