<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AbstractController;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectTasksController extends AbstractController
{
    public function store(Project $project)
    {
        request()->validate([
            'body' => 'required'
        ]);
        
        $project->addTask(request('body'));

        return redirect($project->path());
    }
}
