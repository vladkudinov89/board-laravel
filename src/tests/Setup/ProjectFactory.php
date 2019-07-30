<?php

namespace Tests\Setup;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;

class ProjectFactory
{
    protected $taskCount;
    protected $user;

    public function withTasks($taskCount = 0)
    {
        $this->taskCount = $taskCount;

        return $this;
    }

    public function ownedBy($user)
    {
        $this->user = $user;

        return $this;
    }

    public function create()
    {
     $project =  factory(Project::class)->create([
            'owner_id' => $this->user ?? factory(User::class)->create()->id
        ]);

     factory(Task::class , $this->taskCount )->create([
        'project_id' => $project->id
     ]);

     return $project;
    }
}
