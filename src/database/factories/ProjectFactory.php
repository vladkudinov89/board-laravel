<?php

use App\Models\Project;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(Project::class, function (Faker $faker) {
    return [
        'title' => $this->faker->sentence,
        'description' => $this->faker->paragraph,
        'owner_id' => function (){
            return factory(User::class)->create()->id;
        }
    ];
});
