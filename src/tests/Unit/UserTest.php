<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Support\Collection;
use Tests\Feature\AbstractFeatureTestCase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends AbstractFeatureTestCase
{
    use RefreshDatabase;

    public function test_a_user_has_project()
    {
        $user = factory(User::class)->create();

        $this->assertInstanceOf(Collection::class , $user->projects);
    }

}
