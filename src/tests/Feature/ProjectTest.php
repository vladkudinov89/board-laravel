<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTest extends AbstractFeatureTestCase
{
    use WithFaker, RefreshDatabase, WithoutMiddleware;

    public function test_only_auth_users_can_create_project()
    {
        $this->withoutExceptionHandling();

        $attributes = factory('App\Models\Project')->raw();

        $this
            ->post('/projects', $attributes)
            ->assertRedirect('login');
    }

    public function test_auth_user_can_create_project()
    {

        $this->actingAs(factory(User::class)->create());

        $this->withoutExceptionHandling();

        $attributes = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
        ];

        $this->post('/projects', $attributes)
            ->assertRedirect('/projects');

        $this->assertDatabaseHas('projects', $attributes);

        $this->get('/projects')
            ->assertSee($attributes['title']);
    }

    public function test_only_auth_user_can_view_projects()
    {
        $this
            ->get('/projects')
            ->assertRedirect('login');
    }

    public function test_only_auth_user_can_view_single_project()
    {
        $project = factory('App\Models\Project')->create();

        $this
            ->get($project->path())
            ->assertStatus(403);
    }

    public function test_an_auth_user_cannot_view_another_projects()
    {
        $this->be(factory('App\Models\User')->create());

        $project = factory('App\Models\Project')->create();

        $this->get($project->path())
            ->assertStatus(403);
    }


    public function test_a_project_requires_a_title()
    {
        $attributes = factory('App\Models\Project')->raw(['title' => '']);

        $this->post('/projects', $attributes)
            ->assertSessionHasErrors('title');
    }

    public function test_a_project_requires_a_description()
    {
        $attributes = factory('App\Models\Project')->raw(['description' => '']);

        $this->post('/projects', $attributes)
            ->assertSessionHasErrors('description');
    }

    public function test_a_user_can_view_project()
    {
        $this->be(factory('App\Models\User')->create());

        $this->withoutExceptionHandling();

        $project = factory('App\Models\Project')->create(['owner_id' => auth()->id()]);

        $this->get($project->path())
            ->assertSee($project->title)
            ->assertSee($project->description);
    }

    public function test_it_belongs_to_an_owner()
    {
        $project = factory('App\Models\Project')->create();

        $this->assertInstanceOf(User::class , $project->owner);
    }


}
