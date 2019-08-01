<?php

namespace Feature;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Facades\Tests\Setup\ProjectFactory;
use Tests\Feature\AbstractFeatureTestCase;

class ProjectTasksTest extends AbstractFeatureTestCase
{
    use RefreshDatabase;

    public function test_a_project_can_have_tasks()
    {
        $project = ProjectFactory::withTasks(1)->create();

        $word = $this->faker->word;

        $this
            ->actingAs($project->owner ?? factory(User::class)->create())
            ->post($project->path() . '/tasks', ['body' => $word]);

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
        $project = ProjectFactory::withTasks(1)->create();

        $this
            ->actingAs($project->owner ?? factory(User::class)->create())
            ->patch($project->tasks[0]->path(), [
                'body' => 'changed'
        ]);

        $this->assertDatabaseHas('tasks', [
            'body' => 'changed'
        ]);
    }

    public function test_a_task_can_be_completed()
    {
        $project = ProjectFactory::withTasks(1)->create();

        $this
            ->actingAs($project->owner ?? factory(User::class)->create())
            ->patch($project->tasks[0]->path(), [
                'body' => 'changed',
                'completed' => true
            ]);

        $this->assertDatabaseHas('tasks', [
            'body' => 'changed',
            'completed' => true
        ]);
    }

    public function test_a_task_marked_as_incompleted()
    {
        $project = ProjectFactory::withTasks(1)->create();

        $this
            ->actingAs($project->owner ?? factory(User::class)->create())
            ->patch($project->tasks[0]->path(), [
                'body' => 'changed',
                'completed' => true
            ]);

        $this
            ->actingAs($project->owner ?? factory(User::class)->create())
            ->patch($project->tasks[0]->path(), [
                'body' => 'changed',
                'completed' => false
            ]);

        $this->assertDatabaseHas('tasks', [
            'body' => 'changed',
            'completed' => false
        ]);
    }

    public function test_only_owner_can_update_task_project()
    {
        $this->signIn();

        $project = ProjectFactory::withTasks(1)->create();

        $this
            ->patch($project->tasks[0]->path(), [
            'body' => 'task changed'
        ])
            ->assertStatus(403);

        $this->assertDatabaseMissing('tasks', [
            'body' => 'task changed'
        ]);
    }


    public function test_a_task_require_body()
    {
        $project = ProjectFactory::create();

        $attributes = factory(Task::class)->raw(['body' => '']);

        $this
            ->actingAs($project->owner ?? factory(User::class)->create())
            ->post($project->path() . '/tasks', $attributes)
            ->assertSessionHasErrors('body');
    }

}
