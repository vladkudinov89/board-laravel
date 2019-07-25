<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Collection;
use Tests\TestCase;
use Tests\Unit\AbstractUnitTestCase;

class UserTest extends AbstractUnitTestCase
{
    use RefreshDatabase;

    public function test_a_user_has_project()
    {
        $user = factory(User::class)->create();

        $this->assertInstanceOf(Collection::class , $user->projects);
    }

}
