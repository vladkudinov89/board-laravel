<?php

namespace Tests\Feature;

use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ActivityFeedTest extends AbstractFeatureTestCase
{
    use RefreshDatabase;

    /** @test */
    public function creating_a_project_generates_activity()
    {
        $project  = ProjectFactory::create();

        $this->assertCount(1 , $project->activity);
        $this->assertEquals('created' , $project->activity[0]->description);
    }

    /** @test */
    public function updating_a_project_generates_activity()
    {
        $project  = ProjectFactory::create();

        $project->update(['title' => 'updated']);

        $this->assertCount(2 , $project->activity);

        $this->assertEquals('updated' , $project->activity->last()->description);
    }


}
