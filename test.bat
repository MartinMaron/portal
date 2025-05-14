 @echo off
 setlocal enabledelayedexpansion

 rem =============================
 rem Konfiguration
 rem =============================
 set "PHP_BIN=C:\Users\lenni\.config\herd\bin\php84\php.exe"
 set "PHP_INI=C:\Users\lenni\.config\herd\bin\php84\php.ini"
 set "PHPUNIT_PATH=vendor\phpunit\phpunit\phpunit"
 set "PHPUNIT_CONFIG=phpunit.xml"
 set "TEST_DIR=tests"
 set "TEAMCITY_FLAG=--teamcity"

 rem =============================
 rem Prüfung: PHP vorhanden?
 rem =============================
 if not exist "%PHP_BIN%" (
     echo ❌ PHP Executable nicht gefunden: %PHP_BIN%
     exit /b 1
 )

 rem =============================
 rem PHPUnit ausführen
 rem =============================
 echo Starte PHPUnit mit:
 echo - PHP: %PHP_BIN%
 echo - php.ini: %PHP_INI%
 echo - Config: %PHPUNIT_CONFIG%
 echo - Tests: %TEST_DIR%

 "%PHP_BIN%" -c "%PHP_INI%" ".\%PHPUNIT_PATH%" --configuration "%PHPUNIT_CONFIG%" "%TEST_DIR%" %TEAMCITY_FLAG%

 if errorlevel 1 (
     echo ❌ Tests fehlgeschlagen.
     exit /b 1
 ) else (
     echo ✅ Tests erfolgreich.
 )

 endlocal
