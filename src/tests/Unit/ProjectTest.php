<?php

namespace Tests\Unit;

use App\Models\Project;
use Tests\Feature\AbstractFeatureTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTest extends AbstractFeatureTestCase
{
    use RefreshDatabase;

    public function test_it_has_a_path()
    {
        $project = factory('App\Models\Project')->create();

        $this->assertEquals('/projects/' . $project->id , $project->path());
    }
}
