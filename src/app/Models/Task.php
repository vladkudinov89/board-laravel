<?php

namespace App\Models;

use App\Models\Project;

class Task extends AbstractBaseModel
{
    protected $guarded = [];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
