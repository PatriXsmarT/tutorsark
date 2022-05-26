<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

     /**
     * Indicates whether the default seeder should run before each test.
     *
     * @var bool
     */
    protected $seed = true;

    /**
     * Don't handle things, spit them out.
     */
    protected function noHandling()
    {
        $this->withoutExceptionHandling();

        $this->withoutDeprecationHandling();
    }

    /**
     * Correct password format.
     */
    protected function correctPassword()
    {
        return 'P@ssword1234';
    }

    /**
     * Wrong password format.
     */
    protected function wrongPassword()
    {
        return 'wrong-P@ssword1234';
    }

    /**
     * Wrong password format.
     */
    protected function incorrectPasswordFormat()
    {
        return 'wrong-Password';
    }
}
