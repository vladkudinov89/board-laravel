<?php

use App\Models\Task;
use Faker\Generator as Faker;

$factory->define(Task::class, function (Faker $faker) {
    return [
        'body' => $this->faker->sentence(4),
        'project_id' => factory(\App\Models\Project::class),
        'completed' => false
    ];
});
