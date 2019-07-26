<?php

namespace App\Models;

use App\Models\Project;

/**
 * @property string $body
 * @property int $project_id
 */
class Task extends AbstractBaseModel
{
     protected $fillable = [
        'body',
        'project_id'
    ];

    protected $guarded = [];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
