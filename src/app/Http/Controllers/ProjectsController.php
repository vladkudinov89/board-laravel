<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ProjectsController extends Controller
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

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        if (auth()->check()){
            auth()->user()->projects()->create($attributes);
        } else {
            return redirect('/login');
        }

        return redirect('/projects');
    }
}
