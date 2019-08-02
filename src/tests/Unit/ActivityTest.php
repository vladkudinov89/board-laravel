<?php

namespace Tests\Unit;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\ProjectFactory;

class ActivityTest extends AbstractUnitTestCase
{
    use RefreshDatabase;

    /** @test */
    public function is_has_a_user()
    {
        $user = $this->signIn();

        $project = factory(Project::class)->create(['owner_id' => $user->id]);

        $this->assertEquals($user->id , $project->activity->first()->user_id);
    }

}
