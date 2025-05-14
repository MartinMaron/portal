<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected static bool $dbConfigLoaded = false;

    public function setUp(): void
    {
        parent::setUp();

        if (!self::$dbConfigLoaded) {
            $this->loadTestingDatabaseConfig();
            DB::purge();
            DB::reconnect('mysql');
            self::$dbConfigLoaded = true;
        }

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

    protected function loadTestingDatabaseConfig(): void
    {
        $envTestingPath = base_path('.env.testing');
        if (!file_exists($envTestingPath)) {
            config([
                'database.connections.mysql.driver' => 'mysql',
                'database.connections.mysql.host' => '127.0.0.1',
                'database.connections.mysql.port' => '3306',
                'database.connections.mysql.database' => 'testing',
                'database.connections.mysql.username' => 'laravel',
                'database.connections.mysql.password' => 'secret'
            ]);
            echo "\nWarning: .env.testing file not found. Using fallback configuration.\n";
            return;
        }
        $dbConfig = [];
        $lines = file($envTestingPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (str_contains($line, '=') && !str_starts_with($line, '#')) {
                list($key, $value) = explode('=', $line, 2);
                if (str_starts_with($key, 'DB_')) {
                    $dbConfig[$key] = $value;
                }
            }
        }

        // Konfiguriere die Datenbankverbindung basierend auf den extrahierten Werten
        echo "\nUsing database configuration from .env.testing file:\n";
        if (isset($dbConfig['DB_CONNECTION'])) {
            config(['database.default' => $dbConfig['DB_CONNECTION']]);
        }
        if (isset($dbConfig['DB_HOST'])) {
            config(['database.connections.mysql.host' => $dbConfig['DB_HOST']]);
        }
        if (isset($dbConfig['DB_PORT'])) {
            config(['database.connections.mysql.port' => $dbConfig['DB_PORT']]);
        }
        if (isset($dbConfig['DB_DATABASE'])) {
            config(['database.connections.mysql.database' => $dbConfig['DB_DATABASE']]);
        }
        if (isset($dbConfig['DB_USERNAME'])) {
            config(['database.connections.mysql.username' => $dbConfig['DB_USERNAME']]);
        }
        if (isset($dbConfig['DB_PASSWORD'])) {
            config(['database.connections.mysql.password' => $dbConfig['DB_PASSWORD']]);
        }
    }
}
