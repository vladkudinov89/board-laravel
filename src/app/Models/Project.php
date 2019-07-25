<?php

namespace App\Models;

use App\Models\Task;

/**
 * @property int $id
 * @property string $title
 * @property string $description
 * @property int $owner_id
 *
 * */
class Project extends AbstractBaseModel
{
    protected $table = 'projects';

    protected $fillable = [
        'title',
        'description',
        'owner_id'
    ];

    protected $guarded = [];

    public function path()
    {
        return "/projects/{$this->id}";
    }

    public function owner()
    {
        return $this->belongsTo(User::class);
    }

    public function owner_id()
    {
        return $this->owner_id;
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function addTask($body)
    {
        return $this->tasks()->create(compact('body'));
    }
}
