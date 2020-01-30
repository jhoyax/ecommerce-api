<?php

namespace Tests;

use App\Eloquent\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Airlock\Airlock;

abstract class TestCaseAPI extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Authenticate a given user as the current user
     * to laravel Passport
     *
     * @param App\Eloquent\User|null $user
     * @return App\Eloquent\User
     */
    protected function signInAsAdmin()
    {
        $user = User::find(1);

        Airlock::actingAs($user);

        return $user;
    }

    /**
     * Add prefix to path
     *
     * @param string $path
     * @return string
     */
    protected function path($path = '')
    {
        return '/api/' . $path;
    }
}
