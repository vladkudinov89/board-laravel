<?php

use App\Models\Project;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(Project::class, function (Faker $faker) {
    return [
        'title' => $this->faker->sentence(4),
        'description' => $this->faker->text($maxNbChars = 100)  ,
        'owner_id' => factory(User::class)
    ];
});
