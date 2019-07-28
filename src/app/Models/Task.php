<?php

namespace App\Models;

use App\Models\Project;

/**
 * App\Models\Task
 *
 * @property int $id
 * @property string $body
 * @property int $project_id
 * @property boolean $completed
 * @property-read \App\Models\Project $project
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Task newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Task newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Task query()
 * @mixin \Eloquent
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
