<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function setUp(): void
    {
        parent::setUp();
        config([
            'database.connections.mysql.database' => 'testing'
        ]);

        DB::purge();
        DB::reconnect('mysql');

        if ($this->app->environment() !== 'testing') {
            echo "\nThis test is not running in testing environment and may erase your production database!\n
            Do you want to continue anyway? (y/n): ";
            $handle = fopen('php://stdin', 'r');
            $answer = fgets($handle);
            fclose($handle);
            if (strtolower(trim($answer)) !== 'y') {
                $this->markTestSkipped('Test skipped - not running in testing environment');
            }
        }
    }
}
