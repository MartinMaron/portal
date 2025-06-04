<?php

namespace Tests\Unit;

use Tests\TestCase;

class EnvironmentConfigTest extends TestCase
{
    protected function loadEnvFile(string $path): array
    {
        if (!file_exists($path)) {
            $this->fail("Environment file {$path} does not exist.");
        }

        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $vars = [];

        foreach ($lines as $line) {
            if (str_starts_with(trim($line), '#')) continue;

            if (str_contains($line, '=')) {
                [$key, $value] = explode('=', $line, 2);
                $vars[trim($key)] = trim(trim($value), "\"'");
            }
        }

        return $vars;
    }

    public function testEnvFilesExist()
    {
        $this->assertFileExists(base_path('.env'));
        $this->assertFileExists(base_path('.env.testing'));
        $this->assertFileExists(base_path('.env.development'));
        $this->assertFileExists(base_path('.env.production'));
    }

    public function testAppEnvMatchesFile()
    {
        $envs = [
            '.env.testing' => 'testing',
            '.env.development' => 'development',
            '.env.production' => 'production',
        ];

        foreach ($envs as $file => $expectedAppEnv) {
            $vars = $this->loadEnvFile(base_path($file));
            $this->assertArrayHasKey('APP_ENV', $vars, "$file fehlt APP_ENV");

            if ($expectedAppEnv !== null) {
                $this->assertEquals(
                    $expectedAppEnv,
                    $vars['APP_ENV'],
                    "$file sollte APP_ENV=$expectedAppEnv enthalten"
                );
            }
        }
    }

    public function testDatabaseConnectionsDiffer()
    {
        $envDev = $this->loadEnvFile(base_path('.env.development'));
        $envTesting = $this->loadEnvFile(base_path('.env.testing'));
        $envProd = $this->loadEnvFile(base_path('.env.production'));

        $devId = $envDev['DB_DATABASE'] . $envDev['DB_HOST'] . $envDev['DB_PORT'];
        $testId = $envTesting['DB_DATABASE'] . $envTesting['DB_HOST'] . $envTesting['DB_PORT'];
        $prodId = $envProd['DB_DATABASE'] . $envProd['DB_HOST'] . $envProd['DB_PORT'];

        $this->assertNotEquals($devId, $testId, 'Development und Testing nutzen dieselbe Datenbankverbindung!');
        $this->assertNotEquals($devId, $prodId, 'Development und Production nutzen dieselbe Datenbankverbindung!');
        $this->assertNotEquals($testId, $prodId, 'Testing und Production nutzen dieselbe Datenbankverbindung!');
    }

    public function testAppDebugSetting()
    {
        $envDev = $this->loadEnvFile(base_path('.env.development'));
        $envTesting = $this->loadEnvFile(base_path('.env.testing'));
        $envProd = $this->loadEnvFile(base_path('.env.production'));

        $this->assertEquals('true', strtolower($envDev['APP_DEBUG']), 'APP_DEBUG sollte in development true sein');
        $this->assertEquals('true', strtolower($envTesting['APP_DEBUG']), 'APP_DEBUG sollte in testing true sein');
        $this->assertEquals('false', strtolower($envProd['APP_DEBUG']), 'APP_DEBUG sollte in production false sein');
    }

    public function testWorkflowEnvMatchesDotenvTesting()
    {
        $workflowPath = base_path('.github/workflows/laravel.yml');
        $envTestingPath = base_path('.env.testing');

        $this->assertFileExists($workflowPath, 'Workflow file not found');
        $this->assertFileExists($envTestingPath, '.env.testing file not found');

        $workflowContent = file_get_contents($workflowPath);
        $envTesting = $this->loadEnvFile($envTestingPath);

        // 1. Extrahiere `services.mysql.env` aus dem `test.yml`
        $mysqlServiceEnv = [
            'MYSQL_DATABASE'     => $this->extractYamlEnv($workflowContent, 'MYSQL_DATABASE'),
            'MYSQL_USER'         => $this->extractYamlEnv($workflowContent, 'MYSQL_USER'),
            'MYSQL_PASSWORD'     => $this->extractYamlEnv($workflowContent, 'MYSQL_PASSWORD'),
            'MYSQL_ROOT_PASSWORD'=> $this->extractYamlEnv($workflowContent, 'MYSQL_ROOT_PASSWORD'),
        ];

        // 2. Extrahiere `echo ... >> .env` Werte aus dem Setup-Abschnitt
        $echoOverrides = [
            'DB_CONNECTION' => $this->extractEchoEnv($workflowContent, 'DB_CONNECTION'),
            'DB_HOST'       => $this->extractEchoEnv($workflowContent, 'DB_HOST'),
            'DB_PORT'       => $this->extractEchoEnv($workflowContent, 'DB_PORT'),
            'DB_DATABASE'   => $this->extractEchoEnv($workflowContent, 'DB_DATABASE'),
            'DB_USERNAME'   => $this->extractEchoEnv($workflowContent, 'DB_USERNAME'),
            'DB_PASSWORD'   => $this->extractEchoEnv($workflowContent, 'DB_PASSWORD'),
        ];

        // 3. Validierung: echo-Values müssen zu den `services.mysql.env` passen
        $this->assertEquals('mysql', $echoOverrides['DB_CONNECTION'], 'DB_CONNECTION must be mysql');
        $this->assertEquals('127.0.0.1', $echoOverrides['DB_HOST'], 'DB_HOST mismatch');
        $this->assertEquals('3306', $echoOverrides['DB_PORT'], 'DB_PORT mismatch');
        $this->assertEquals($mysqlServiceEnv['MYSQL_DATABASE'], $echoOverrides['DB_DATABASE'], 'DB_DATABASE mismatch');
        $this->assertEquals($mysqlServiceEnv['MYSQL_USER'], $echoOverrides['DB_USERNAME'], 'DB_USERNAME mismatch');
        $this->assertEquals($mysqlServiceEnv['MYSQL_PASSWORD'], $echoOverrides['DB_PASSWORD'], 'DB_PASSWORD mismatch');

        // 4. Validierung: echo-Values müssen mit .env.testing übereinstimmen
        foreach ($echoOverrides as $key => $expectedValue) {
            $this->assertArrayHasKey($key, $envTesting, ".env.testing missing {$key}");
            $this->assertEquals(
                $expectedValue,
                $envTesting[$key],
                "{$key} in .env.testing does not match GitHub workflow DB config"
            );
        }
    }

    /**
     * Holt einfache key: value Zeilen aus YAML-Blöcken.
     */
    protected function extractYamlEnv(string $content, string $key): ?string
    {
        $pattern = '/'.preg_quote($key, '/').'\s*:\s*(.+)/';
        if (preg_match($pattern, $content, $matches)) {
            return trim($matches[1], "\"' ");
        }
        return null;
    }

    /**
     * Holt Werte aus echo-Statements wie `echo "DB_HOST=127.0.0.1" >> .env`
     */
    protected function extractEchoEnv(string $content, string $key): ?string
    {
        $pattern = '/echo\s+"'.preg_quote($key).'=(.+?)"\s+>>\s+\.env/';
        if (preg_match($pattern, $content, $matches)) {
            return trim($matches[1], "\"' ");
        }
        return null;
    }

}
