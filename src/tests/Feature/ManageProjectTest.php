<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class ManageProjectTest extends AbstractFeatureTestCase
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
        $this->signIn();

        $this->withoutExceptionHandling();

        $this->get('/projects/create')->assertStatus(200);

        $attributes = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->sentence,
            'notes' => 'General notes here.'
        ];

        $response = $this->post('/projects', $attributes);

        $project = Project::where($attributes)->first();

        $response->assertRedirect($project->path());

        $this->assertDatabaseHas('projects', $attributes);

        $this->get($project->path())
            ->assertSee($attributes['title'])
            ->assertSee($attributes['description'])
            ->assertSee($attributes['notes']);
    }

    public function test_a_user_can_update_a_project()
    {
        $this->signIn();

        $this->withoutExceptionHandling();

        $project = factory('App\Models\Project')->create(['owner_id' => auth()->id()]);

        $this->patch($project->path(), [
            'notes' => 'changed notes.'
        ]);

        $this
            ->assertDatabaseHas('projects', [
                'notes' => 'changed notes.'
        ]);
    }

    public function test_an_unauth_user_cannot_update_project()
    {
        $project = factory('App\Models\Project')->create();

        $this
            ->patch($project->path(), [
                'notes' => 'changed'
            ])
            ->assertStatus(403);
    }


    public function test_only_auth_user_can_view_projects()
    {
        $this
            ->get('/projects')
            ->assertRedirect('/login');
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
        $this->signIn();

        $project = factory('App\Models\Project')->create();

        $this->get($project->path())
            ->assertStatus(403);
    }


    public function test_a_project_requires_a_title()
    {
        $this->signIn();

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

    public function test_a_user_can_view_own_project()
    {
        $this->signIn();

        $project = factory('App\Models\Project')->create(['owner_id' => auth()->id()]);

        $this->get($project->path())
            ->assertSee($project->title)
            ->assertSee($project->description);
    }

    public function test_an_auth_user_can_create_project()
    {
        $this->signIn();

       $this->get('/projects/create')->assertStatus(200);


    }


}
