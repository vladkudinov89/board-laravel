<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Str;
use Tests\AbstractTestCase;

abstract class AbstractFeatureTestCase extends AbstractTestCase
{
    /**
     * @var string
     */
    protected $admin_user_login;

    /**
     * @var string
     */
    protected $admin_user_password;

    /**
     * @var User
     */
    protected $admin_user;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->admin_user_login    = 'feature_test_' . $this->faker->userName;
        $this->admin_user_password = Str::upper(Str::random(6)) . Str::random(6) . random_int(1, 50) . '!';

        $this->admin_user = User::create([
            'login'        => $this->admin_user_login,
            'password'     => $this->admin_user_password,
            'display_name' => $this->faker->name,
        ]);

        $this->startSession();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        $this->flushSession();

        $this->admin_user->forceDelete();

        parent::tearDown();
    }

    protected function signIn($user = null)
    {
        return $this->actingAs($user ?: factory('App\Models\User')->create());
    }
}
