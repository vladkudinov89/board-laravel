<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class ManageProjectTest extends AbstractFeatureTestCase
{
    use WithFaker, RefreshDatabase, WithoutMiddleware;

    public function test_only_auth_users_can_create_project()
    {
        $attributes = factory('App\Models\Project')->raw();

        $this
            ->post('/projects', $attributes)
            ->assertRedirect('login');
    }

    public function test_auth_user_can_create_project()
    {
        $this->withMiddleware();

        $user = $this->signIn();

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

        $this
            ->actingAs($project->owner ?? $user)
            ->get($project->path())
            ->assertSee($attributes['title'])
            ->assertSee($attributes['description'])
            ->assertSee($attributes['notes']);
    }

    /** @test */
    public function tasks_can_be_included_as_part_a_new_project_creation()
    {
        $this->signIn();

        $attributes = factory(Project::class)->raw();

        $attributes['tasks'] = [
            ['body' => 'task1'],
            ['body' => 'task2'],
        ];

        $this->post('/projects', $attributes);

//        $this->assertDatabaseHas('projects' , $attributes);

        $this->assertCount(2, Project::first()->tasks);
    }


    /** @test */
    public function a_user_can_see_all_proj_they_have_been_invited_to_on_their_dashboard()
    {
        $this->withMiddleware();

        $user = $this->signIn();

        $project = factory(Project::class)->create(['owner_id' => $user]);

        $project->invite($user);

        $this->get('/projects')
            ->assertSee($project->title);
    }

    /** @test */
    public function unauth_user_cannot_delete_project()
    {
        $project = ProjectFactory::create();

        $this
            ->delete($project->path())
            ->assertRedirect('/login');

        $user = $this->signIn();

        $this
            ->delete($project->path())
            ->assertStatus(403);

        $project->invite($user);

        $this
            ->actingAs($user)
            ->delete($project->path())
            ->assertStatus(403);
    }


    /** @test */
    public function user_can_delete_own_project()
    {
        $user = $this->signIn();

        $project = ProjectFactory::create();

        $this
            ->actingAs($project->owner ?? $user)
            ->delete($project->path())
            ->assertRedirect('/projects');

        $this->assertDatabaseMissing('projects', $project->only('id'));
    }


    public function test_a_user_can_update_a_project()
    {
        $user = $this->signIn();

        $project = ProjectFactory::create();

        $this
            ->actingAs($project->owner ?? $user)
            ->patch($project->path(), [
                'notes' => 'changed notes.'
            ]);

        $this
            ->assertDatabaseHas('projects', [
                'notes' => 'changed notes.'
            ]);
    }

    public function test_an_unauth_user_cannot_update_project()
    {
        $project = ProjectFactory::create();

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
        $project = ProjectFactory::create();

        $this
            ->get($project->path())
            ->assertStatus(403);
    }

    public function test_an_auth_user_cannot_view_another_projects()
    {
        $project = ProjectFactory::create();

        $this
            ->get($project->path())
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
        $this->withMiddleware();

        $user = $this->signIn();

        $project = factory('App\Models\Project')->create(['owner_id' => $user]);

        $this
            ->actingAs($user)
            ->get($project->path())
            ->assertSee($project->title)
            ->assertSee($project->description);
    }

    public function test_an_auth_user_can_create_project()
    {
        $this->signIn();

        $this->get('/projects/create')->assertStatus(200);

    }

}
