<?php

namespace App\Models;

use App\Models\Project;

/**
 * @property string $body
 * @property int $project_id
 * @property boolean $completed
 */
class Task extends AbstractBaseModel
{
    protected $fillable = [
        'body',
        'project_id',
        'completed'
    ];

    protected $guarded = [];

    protected $touches = ['project'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function path()
    {
        return "/projects/{$this->project->id}/tasks/{$this->id}";
    }
}
