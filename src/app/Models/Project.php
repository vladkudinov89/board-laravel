<?php

namespace App\Models;

use App\Models\Activity;
use App\Models\Task;

/**
 * App\Models\Project
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property int $owner_id
 * @property string $notes
 * @property-read User $owner
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Task[] $tasks
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Project newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Project newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Project query()
 * @mixin \Eloquent
 */
class Project extends AbstractBaseModel
{
    protected $table = 'projects';

    protected $guarded = [];

    public $old = [];

    public function path()
    {
        return "/projects/{$this->id}";
    }

    public function owner()
    {
        return $this->belongsTo(User::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function addTask($body)
    {
        return $this->tasks()->create(compact('body'));
    }

    public function activity()
    {
        return $this->hasMany(Activity::class)->latest();
    }

    public function recordActivity(string $description)
    {
        $this->activity()->create([
            'description' => $description,
            'changes' => $this->activityChanges($description)
        ]);
    }

    public function activityChanges($description)
    {
        if ($description == 'updated'){
            return [
                'before' => array_except(array_diff($this->old, $this->getAttributes()) , 'updated_at'),
                'after' => array_except($this->getChanges() , 'updated_at')
            ];
        }
    }
}
