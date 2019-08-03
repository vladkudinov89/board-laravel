<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectInvitationRequest;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class ProjectInvitationsController extends AbstractController
{
    public function store(Project $project , ProjectInvitationRequest $request)
    {
        $project->invite(User::whereEmail(\request('email'))->first());

        return redirect('/projects');
    }
}
