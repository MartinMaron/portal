@echo off
echo **********************
echo Loesche alle build Dateien...
echo **********************

set CLEANUP_ERRORS=0

if exist vendor (
    echo Loesche Ordner 'vendor'...
    rmdir /s /q vendor 2>nul
    if exist vendor (
        set /a CLEANUP_ERRORS+=1
    )
)

if exist node_modules (
    echo Loesche Ordner 'node_modules'...
    rmdir /s /q node_modules 2>nul
    if exist node_modules (
        set /a CLEANUP_ERRORS+=1
    )
)

if exist storage\debugbar (
    echo Loesche Debugbar-Ordner 'storage/debugbar'...
    rmdir /s /q storage\debugbar 2>nul
    if exist storage\debugbar (
        set /a CLEANUP_ERRORS+=1
    )
)

if exist .phpunit.result.cache (
    echo Loesche PHPUnit Cache '.phpunit.result.cache'...
    del /q .phpunit.result.cache 2>nul
    if exist .phpunit.result.cache (
        set /a CLEANUP_ERRORS+=1
    )
)

if exist public\hot (
    echo Loesche Datei 'public/hot'...
    del /q public\hot 2>nul
    if exist public\hot (
        set /a CLEANUP_ERRORS+=1
    )
)

if exist storage\logs\laravel.log (
    echo Loesche Logdatei 'storage/logs/laravel.log'...
    del /q storage\logs\laravel.log 2>nul
    if exist storage\logs\laravel.log (
        set /a CLEANUP_ERRORS+=1
    )
)

if exist composer.lock (
    echo Loesche 'composer.lock'...
    del /q composer.lock 2>nul
    if exist composer.lock (
        set /a CLEANUP_ERRORS+=1
    )
)

if exist package-lock.json (
    echo Loesche 'package-lock.json'...
    del /q package-lock.json 2>nul
    if exist package-lock.json (
        set /a CLEANUP_ERRORS+=1
    )
)

if exist public\build (
    echo Loesche Ordner 'public/build'...
    rmdir /s /q public\build 2>nul
    if exist public\build (
        set /a CLEANUP_ERRORS+=1
    )
)

if exist public\storage (
    echo Loesche Ordner 'public/storage'...
    rmdir /s /q public\storage 2>nul
    if exist public\storage (
        set /a CLEANUP_ERRORS+=1
    )
)

echo **********************
if %CLEANUP_ERRORS% GTR 0 (
    echo HINWEIS: Einige Dateien oder Ordner konnten nicht geloescht werden.
    echo         Dies ist meistens der Fall, wenn die Anwendung noch laeuft.
    echo         Stoppe die Website, um alle Dateien erfolgreich zu loeschen.
) else (
    echo Cleanup erfolgreich abgeschlossen.
)
echo **********************
