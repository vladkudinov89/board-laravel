<?php

namespace Tests\Unit;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;

class UserTest extends AbstractUnitTestCase
{
    use RefreshDatabase;

    public function test_a_user_has_project()
    {
        $user = factory(User::class)->create();

        $this->assertInstanceOf(Collection::class , $user->projects);
    }

    /** @test */
    public function a_user_can_accessible_projects()
    {
        $john = $this->signIn();

        $project = factory(Project::class)->create(['owner_id' => $john->id]);

        $this->assertEquals($project->owner_id , $john->id);

        $this->assertCount( 1, $john->accessibleProjects());

        $sally = factory(User::class)->create();

        $nick = factory(User::class)->create();

        factory(Project::class)->create(['owner_id' => $sally->id])->invite($nick);

        $this->assertCount(1 , $john->accessibleProjects());

        $this->assertCount(1 , $nick->accessibleProjects());

        factory(Project::class)->create(['owner_id' => $sally->id])->invite($john);

        $this->assertCount(2 , $john->accessibleProjects());

        $this->assertCount(2 , $sally->accessibleProjects());

    }


}
