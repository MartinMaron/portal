<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class CheckFatalJsErrors extends Command
{
    protected $signature = 'debug:js-errors';
    protected $description = 'Check all GET routes for common JS error patterns in HTML output';

    protected array $errorPatterns = [
        'Uncaught',
        'ReferenceError',
        'TypeError',
        'SyntaxError',
        'RangeError',
        'Warning',
        'Failed to load resource',
        'Cannot read property',
        'is not defined',
        'Unexpected token',
        'Unhandled promise rejection',
    ];

    public function handle()
    {
        $routes = collect(Route::getRoutes())->filter(function ($route) {
            return in_array('GET', $route->methods())
                && empty($route->parameterNames())
                && !Str::startsWith($route->uri(), 'api');
        });

        foreach ($routes as $route) {
            $uri = '/' . ltrim($route->uri(), '/');
            $this->info("🔗 Prüfe Route: $uri");

            try {
                $response = app()->handle(request()->create($uri, 'GET'));
                $html = $response->getContent();

                $foundErrors = [];

                foreach ($this->errorPatterns as $pattern) {
                    if (stripos($html, $pattern) !== false) {
                        $foundErrors[] = $pattern;
                    }
                }

                if (count($foundErrors) > 0) {
                    $this->error("  ⚠️ Fehler/Muster gefunden: " . implode(', ', $foundErrors));
                    foreach ($foundErrors as $error) {
                        $pos = stripos($html, $error);
                        $snippet = substr($html, max(0, $pos - 30), 100);
                        $this->line("    ... " . trim($snippet) . " ...");
                    }
                } else {
                    $this->info("  ✅ Keine JS-Fehler-Muster gefunden.");
                }
            } catch (\Throwable $e) {
                $this->error("  ❌ Fehler beim Laden: " . $e->getMessage());
            }

            $this->newLine();
        }

        return 0;
    }
}
