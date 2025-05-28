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
            echo "Test1\n";
            $projectRoot = dirname(__DIR__);
            $envTestingPath = $projectRoot . '/.env.testing';
            if (!file_exists($envTestingPath)) {
                echo "\nWarning: .env.testing file not found. Using fallback configuration from phpunit.xml.\n";
            }
            self::$dbConfigLoaded = true;
        }
    }


    public function setUp(): void
    {
        parent::setUp();
        echo "Test2\n";
        if ($this->app->environment() !== 'testing') {
            echo "\nThis test is not running in testing environment and may erase your production database!\n
            You can change this either in the phpunit.xml file or by setting the environment variable APP_ENV to testing.\n
            Do you want to continue anyway? (y/n):\n";
            $handle = fopen('php://stdin', 'r');
            $answer = fgets($handle);
            fclose($handle);
            if (strtolower(trim($answer)) !== 'y') {
                $this->markTestSkipped('Test skipped - not running in testing environment');
            }
        }
    }

}
