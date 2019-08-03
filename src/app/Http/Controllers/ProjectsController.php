<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;

class ProjectsController extends AbstractController
{
    public function index()
    {
        if (auth()->check()){
            $projects = auth()->user()->accessibleProjects();
        } else {
            return redirect('/login');
        }

        return view('projects.index',  compact('projects'));
    }

    /**
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws AuthorizationException
     */
    public function show(int $id)
    {
        $project = Project::find($id);

            $this->authorize('update', $project);

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
            'notes' => 'min:3'
        ]);

        if (auth()->check()){
            $project = auth()->user()->projects()->create($attributes);
        } else {
            return redirect('/login');
        }

        return redirect($project->path());
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws AuthorizationException
     */
    public function update(int $id)
    {
        $project = Project::find($id);

        request()->validate([
            'notes' => 'required'
        ]);

        $this->authorize('update', $project);

        $project->update([
            'notes' => request('notes')
        ]);

        return redirect($project->path());
    }

    public function destroy(int $id)
    {
        $project = Project::find($id);

        if (auth()->check()){

            $this->authorize('manage', $project);

            $project->delete();

        } else {
            return redirect('/login');
        }

        return redirect('projects');
    }
}
