<?php

namespace Tests\Unit;

use App\Models\User;
use Tests\AbstractTestCase;

abstract class AbstractUnitTestCase extends AbstractTestCase
{
    protected function signIn($user = null)
    {
        $user  = $user ?: factory(User::class)->create();

        $this->actingAs($user);

        return $user;
    }
}
