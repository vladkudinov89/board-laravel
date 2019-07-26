<?php

namespace Feature;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Feature\AbstractFeatureTestCase;

class ProjectTasksTest extends AbstractFeatureTestCase
{
    use RefreshDatabase;

    public function test_a_project_can_have_tasks()
    {
        $this->signIn();

        $project = auth()->user()->projects()->create(
            factory(Project::class)->raw()
        );

        $word = $this->faker->word;

        $this->post($project->path() . '/tasks', ['body' => $word]);

        $this->get($project->path())
            ->assertSee($word);
    }

    public function test_only_a_owner_of_a_project_may_add_task()
    {
        $this->signIn();

        $project = factory(Project::class)->create();

        $this->post($project->path() . '/tasks', ['body' => 'Test task'])
            ->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'Test task']);

    }

    public function test_a_task_can_be_updated()
    {
        $this->signIn();

        $project = auth()->user()->projects()->create(
            factory(Project::class)->raw()
        );

        $task = $project->addTask('test task');

        $this->patch($task->path(), [
            'body' => 'changed',
            'completed' => true
        ]);

        $this->assertDatabaseHas('tasks', [
            'body' => 'changed',
            'completed' => true
        ]);
    }

    public function test_only_owner_can_update_task_project()
    {
        $this->signIn();

        $project = factory('App\Models\Project')->create();

        $task = $project->addTask('test task');

        $this->patch($task->path(), [
            'body' => 'task changed'
        ])
            ->assertStatus(403);

        $this->assertDatabaseMissing('tasks', [
            'body' => 'task changed'
        ]);
    }


    public function test_a_task_require_body()
    {
        $this->signIn();

        $project = auth()->user()->projects()->create(
            factory('App\Models\Project')->raw()
        );

        $attributes = factory(Task::class)->raw(['body' => '']);

        $this->post($project->path() . '/tasks', $attributes)
            ->assertSessionHasErrors('body');
    }

}
