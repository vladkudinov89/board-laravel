<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = factory('App\Models\User')->create(['email'=>'vlad@test.ru']);

        $projects = factory('App\Models\Project' , 5)->create(['owner_id' => $user->id]);

        foreach ($projects as $project) {
            factory('App\Models\Task' , 4)->create(['project_id' => $project->id]);
        }
    }
}
