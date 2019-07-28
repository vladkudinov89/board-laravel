<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\AbstractTestCase;

abstract class AbstractFeatureTestCase extends AbstractTestCase
{
    protected function signIn($user = null)
    {
        $user  = $user ?: factory(User::class)->create();

        $this->actingAs($user);

        return $user;
    }
}
