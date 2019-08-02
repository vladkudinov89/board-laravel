<?php

namespace Tests\Unit;

use App\Models\Project;
use App\Models\User;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Unit\AbstractUnitTestCase;

class ProjectTest extends AbstractUnitTestCase
{
    use RefreshDatabase;

    public function test_it_has_a_path()
    {
        $project = factory('App\Models\Project')->create();

        $this->assertEquals('/projects/' . $project->id , $project->path());
    }

    public function test_it_can_add_task()
    {
        $this->signIn();

        $project = factory('App\Models\Project')->create();

        $task = $project->addTask('Test task');

        $this->assertCount(1, $project->tasks);

        $this->assertTrue($project->tasks->contains($task));
    }

    /** @test */
    public function it_can_invite_user()
    {
        $project = factory('App\Models\Project')->create();

        $project->invite($newUser = factory(User::class)->create());

        $this->assertTrue($project->members->contains($newUser));
    }

}
