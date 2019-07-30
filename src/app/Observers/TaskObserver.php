<?php

namespace App\Observers;

use App\Models\Task;

class TaskObserver
{
    /**
     * Handle the app models task "created" event.
     *
     * @param  Task  $task
     * @return void
     */
    public function created(Task $task)
    {
        $task->project->recordActivity('created_task');
    }

    /**
     * Handle the app models task "deleted" event.
     *
     * @param  Task  $task
     * @return void
     */
    public function deleted(Task $task)
    {
        $task->project->recordActivity('deleted_task');
    }
}
