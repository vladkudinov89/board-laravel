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

       $project = factory('App\Models\Project')->create(['owner_id' => auth()->id()]);

       $this->post($project->path() . '/tasks' , ['body' => "Test Task"]);

       $this->get($project->path())->assertSee('Test Task');
   }

    public function test_only_a_owner_of_a_project_may_add_task()
    {
      $this->signIn();

      $project = factory(Project::class)->create();

      $this->post($project->path() . '/tasks', ['body' => 'Test task'])
      ->assertStatus(403);

      $this->assertDatabaseMissing('tasks' , ['body' => 'Test task']);

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
