@echo off
echo **********************
echo Lösche alle build Dateien...
echo **********************

if exist vendor (
    echo Lösche Ordner 'vendor'...
    rmdir /s /q vendor
)

if exist node_modules (
    echo Lösche Ordner 'node_modules'...
    rmdir /s /q node_modules
)

if exist storage\debugbar (
    echo Lösche Debugbar-Ordner 'storage/debugbar'...
    rmdir /s /q storage\debugbar
)

if exist .phpunit.result.cache (
    echo Lösche PHPUnit Cache '.phpunit.result.cache'...
    del /q .phpunit.result.cache
)

rem Lösche public/hot
if exist public\hot (
    echo Lösche Datei 'public/hot'...
    del /q public\hot
)

if exist storage\logs\laravel.log (
    echo Lösche Logdatei 'storage/logs/laravel.log'...
    del /q storage\logs\laravel.log
)

if exist composer.lock (
    echo Lösche 'composer.lock'...
    del /q composer.lock
)

if exist package-lock.json (
    echo Lösche 'package-lock.json'...
    del /q package-lock.json
)

if exist public\build (
    echo Lösche Ordner 'public/build'...
    rmdir /s /q public\build
)

if exist public\storage (
    echo Lösche Ordner 'public/storage'...
    rmdir /s /q public\storage
)

pause
