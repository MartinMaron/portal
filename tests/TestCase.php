<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function setUp(): void
    {
        parent::setUp();
        config(['database.connections.mysql.database' => 'testing']);

        if ($this->app->environment() !== 'testing') {
            $this->markTestSkipped('This Test must be run in testing environment, please run with --env=testing');
        }
    }
}
