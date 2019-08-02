<?php

namespace Tests\Feature;

use App\Models\User;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InvitationTest extends AbstractFeatureTestCase
{
    use RefreshDatabase;

    /** @test */
    public function non_owners_may_not_invite_users()
    {
        $project = ProjectFactory::create();

        $user = factory(User::class)->create();

        $this
            ->actingAs($user)
            ->post($project->path().'/invitations' , [])
            ->assertStatus(403);
    }

    /** @test */
    public function a_project_can_invite_a_user()
    {
        $user = $this->signIn();

        $project = ProjectFactory::create();

        $inviteUser = factory(User::class)->create();

        $this
            ->actingAs($project->owner ?? $user)
            ->post($project->path() . '/invitations' , [
                'email' => $inviteUser->email
            ])
            ->assertRedirect('projects');

        $this->assertTrue($project->members->contains($inviteUser));
    }

    /** @test */
    public function invited_users_may_update_project_details()
    {
        $project = ProjectFactory::create();

        $project->invite($newUser = factory(User::class)->create());

        $this->signIn($newUser);

        $this->post(action('ProjectTasksController@store' , $project) , $task = ['body' => 'foo task']);

        $this->assertDatabaseHas('tasks' , $task);
    }

    /** @test */
    public function the_invited_email_must_be_associated()
    {
        $user = $this->signIn();

        $project = ProjectFactory::create();

        $this
            ->actingAs($project->owner ?? $user)
            ->post($project->path() . '/invitations' , [
                'email' => 'bad@email.com'
            ])
        ->assertSessionHasErrors([
            'email' => 'You must have account.'
        ]);
    }
}
