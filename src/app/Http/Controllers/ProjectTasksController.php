<?php

namespace App\Http\Controllers;

use App\Models\{Project , Task};

class ProjectTasksController extends AbstractController
{
    public function store(Project $project)
    {

        $this->authorize('update' , $project);

        request()->validate([
            'body' => 'required'
        ]);

        $project->addTask(request('body'));

        return redirect($project->path());
    }

    public function update(Project $project , Task $task)
    {
        $this->authorize('update' , $task->project);

        request()->validate([
            'body' => 'required'
        ]);

        $task->update([
            'body' => request('body')
        ]);

        if(request('completed')){
            $task->complete();
        } else {
            $task->incomplete();
        }

        return redirect($project->path());
    }
}
