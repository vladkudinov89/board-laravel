<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AbstractController;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectsController extends AbstractController
{
    public function index()
    {
        if (auth()->check()){
            $projects = auth()->user()->projects;
        } else {
            return redirect('/login');
        }

        return view('projects.index',  compact('projects'));
    }

    public function show(int $id)
    {
        $project = Project::find($id);

        if(auth()->id() !== $project->owner_id()){
            return abort(403);
        }

        return view('projects.show' , compact('project'));
    }

    public function create()
    {
        return view('projects.create');
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        if (auth()->check()){
            $project = auth()->user()->projects()->create($attributes);
        } else {
            return redirect('/login');
        }

        return redirect($project->path());
    }
}
