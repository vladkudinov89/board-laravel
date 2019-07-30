<?php

namespace Tests\Feature;

use App\Models\User;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TriggerActivityTest extends AbstractFeatureTestCase
{
    use RefreshDatabase;

    /** @test */
    public function creating_a_project()
    {
        $project  = ProjectFactory::withTasks(0)->create();

        $this->assertCount(1 , $project->activity);

        $this->assertEquals('created' , $project->activity[0]->description);
    }

    /** @test */
    public function updating_a_project()
    {
        $project  = ProjectFactory::withTasks(0)->create();

        $project->update(['title' => 'updated']);

        $this->assertCount(2 , $project->activity);

        $this->assertEquals('updated' , $project->activity->last()->description);
    }

    /** @test */
    public function creating_a_new_task()
    {
        $project  = ProjectFactory::withTasks(0)->create();

        $project->addTask('test');

        $this->assertCount(2 , $project->activity);

        $this->assertEquals('created_task' , $project->activity->last()->description);
    }

    /** @test */
    public function completed_a_new_task()
    {
        $project  = ProjectFactory::withTasks(1)->create();

        $this
            ->actingAs($project->owner ?? factory(User::class)->create())
            ->patch($project->tasks->last()->path() , [
                'body' => 'foobar',
                'completed' => true
            ]);

        $this->assertDatabaseHas('tasks', [
            'body' => 'foobar',
            'completed' => true
        ]);

        $this->assertDatabaseHas('activities', [
                'project_id' => $project->id,
                'description' => 'completed_task'
    ]);

        $this->assertCount(3 , $project->activity);

       $this->assertEquals('completed_task' , $project->activity->last()->description);
    }

    /** @test */
    public function incompleted_a_new_task()
    {
        $project  = ProjectFactory::withTasks(1)->create();

        $this
            ->actingAs($project->owner)
            ->patch($project->tasks->last()->path() , [
                'body' => 'foobar',
                'completed' => true
            ]);

        $this->assertCount(3 , $project->activity);

        $this
            ->actingAs($project->owner)
            ->patch($project->tasks->last()->path() , [
                'body' => 'foobar',
                'completed' => false
            ]);

        $this->assertCount(4 , $project->fresh()->activity);

        $this->assertEquals('incompleted_task' , $project->fresh()->activity->last()->description);
    }

    /** @test */
    public function it_deleted_a_task()
    {
        $project  = ProjectFactory::withTasks(1)->create();

        $project->tasks[0]->delete();

        $this->assertCount(3 , $project->fresh()->activity);
    }


}
