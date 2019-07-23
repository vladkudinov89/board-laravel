<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ProjectsController extends Controller
{
    public function index()
    {
        $projects = Project::all();

        return view('projects.index',  compact('projects'));
    }

    public function show(int $id)
    {
        $project = Project::find($id);

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
