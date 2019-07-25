<?php

use App\Models\Project;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(Project::class, function (Faker $faker) {
    return [
        'title' => $this->faker->sentence(4),
        'description' => $this->faker->paragraph(4),
        'owner_id' => function (){
            return factory(User::class)->create()->id;
        }
    ];
});
