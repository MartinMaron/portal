<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected static bool $dbConfigLoaded = false;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        if (!self::$dbConfigLoaded) {
            $projectRoot = dirname(__DIR__);
            $envTestingPath = $projectRoot . '/.env.testing';
            if (!file_exists($envTestingPath)) {
                echo "\nWarning: .env.testing file not found. Using fallback configuration from phpunit.xml.\n";
            }
            self::$dbConfigLoaded = true;
        }

        $appEnv = getenv('APP_ENV');
        if ($appEnv && $appEnv !== 'testing') {
            echo
            "\nWarning:    This test is not running in testing environment and may erase your production database!
            Set APP_ENV=testing in phpunit.xml/.env.testing or use --env=testing\n";
        }
    }


    public function setUp(): void
    {
        parent::setUp();
        if ($this->app->environment() !== 'testing') {
            $this->markTestSkipped('Test skipped - not running in testing environment');
        }
    }

}
