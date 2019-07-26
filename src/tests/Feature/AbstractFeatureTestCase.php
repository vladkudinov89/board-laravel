<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\AbstractTestCase;

abstract class AbstractFeatureTestCase extends AbstractTestCase
{
    protected function signIn($user = null)
    {
        return $this->actingAs($user ?: factory(User::class)->create());
    }
}
