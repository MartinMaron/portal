<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function setUp(): void
    {
        parent::setUp();

        if ($this->app->environment() !== 'testing') {
            $this->markTestSkipped('These tests must be run in testing environment to protect your database.');
        }

        if (config('database.connections.mysql.database') !== 'development') {
            $this->markTestSkipped('Tests must use testing database, not production database.');
        }

    }

}
