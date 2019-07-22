<?php

namespace App\Models;

/**
 *  @property int $id
 *  @property string $title
 *  @property string $description
 *
 * */

class Project extends AbstractBaseModel
{
    protected $table = 'projects';

    protected $guarded = [];

    public function path()
    {
        return "/projects/{$this->id}";
    }
}
