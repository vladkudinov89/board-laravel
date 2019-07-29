<?php

namespace Tests\Unit;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskTest extends AbstractUnitTestCase
{
    use RefreshDatabase;

    public function test_it_belongs_project()
    {
        $task = factory(Task::class)->create();

        $this->assertInstanceOf(Project::class , $task->project);
    }

    public function test_it_has_a_path()
    {
        $task = factory(Task::class)->create();

        $this->assertEquals('/projects/' . $task->project->id . '/tasks/' . $task->id, $task->path());
    }

        /** @test */
    public function it_can_completed()
    {
        $task = factory(Task::class)->create();

        $this->assertFalse($task->completed);

        $task->complete();
        
        $this->assertTrue($task->fresh()->completed);
    }
}
