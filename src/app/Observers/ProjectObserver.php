<?php

namespace App\Observers;

use App\Models\Activity;
use App\Models\Project;

class ProjectObserver
{
    /**
     * Handle the project "created" event.
     *
     * @param  Project  $project
     * @return void
     */
    public function created(Project $project)
    {
       $this->recordActivity('created' , $project);
    }

    /**
     * Handle the project "updated" event.
     *
     * @param  Project  $project
     * @return void
     */
    public function updated(Project $project)
    {
        $this->recordActivity('updated' , $project);
    }

    protected function recordActivity(string $type ,Project $project)
    {
        Activity::create([
            'project_id' => $project->id,
            'description' => $type
        ]);
    }
}
