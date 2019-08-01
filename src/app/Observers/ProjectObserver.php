<?php

namespace App\Observers;

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
        $project->recordActivity('created');
    }

    public function updating(Project $project)
    {
        $project->old = $project->getOriginal();
    }

    /**
     * Handle the project "updated" event.
     *
     * @param  Project  $project
     * @return void
     */
    public function updated(Project $project)
    {
        $project->recordActivity('updated');
    }
}
