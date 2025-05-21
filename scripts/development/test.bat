 @echo off
 setlocal enabledelayedexpansion

if exist "%LOCALAPPDATA%\Programs\php\php.exe" (
    set "PHP_BIN=%LOCALAPPDATA%\Programs\php\php.exe"
    set "PHP_INI=%LOCALAPPDATA%\Programs\php\php.ini"
) else if exist "C:\php\php.exe" (
    set "PHP_BIN=C:\php\php.exe"
    set "PHP_INI=C:\php\php.ini"
) else if exist "C:\xampp\php\php.exe" (
    set "PHP_BIN=C:\xampp\php\php.exe"
    set "PHP_INI=C:\xampp\php\php.ini"
) else if exist "%USERPROFILE%\.config\herd\bin\php84\php.exe" (
    set "PHP_BIN=%USERPROFILE%\.config\herd\bin\php84\php.exe"
    set "PHP_INI=%USERPROFILE%\.config\herd\bin\php84\php.ini"
) else (
    set "PHP_BIN=php"
    set "PHP_INI="
)
 set "PHPUNIT_PATH=vendor\phpunit\phpunit\phpunit"
 set "PHPUNIT_CONFIG=phpunit.xml"
 set "TEST_DIR=tests"
 set "TEAMCITY_FLAG=--teamcity"

if "%PHP_BIN%"=="php" (
    where php >nul 2>nul
    if errorlevel 1 (
        echo PHP Executable nicht gefunden.
        exit /b 1
    )
) else if not exist "%PHP_BIN%" (
    echo PHP Executable nicht gefunden: %PHP_BIN%
    exit /b 1
)

if not exist "%PHPUNIT_PATH%" (
    echo PHPUnit nicht gefunden in: %PHPUNIT_PATH%
    echo Stelle sicher, dass Composer-Abhängigkeiten installiert wurden.
    exit /b 1
)

 echo Starte PHPUnit mit:
 echo - PHP: %PHP_BIN%
 if not "%PHP_INI%"=="" echo - php.ini: %PHP_INI%
 echo - Config: %PHPUNIT_CONFIG%
 echo - Tests: %TEST_DIR%

if "%PHP_INI%"=="" (
    "%PHP_BIN%" "%PHPUNIT_PATH%" --configuration "%PHPUNIT_CONFIG%" "%TEST_DIR%" %TEAMCITY_FLAG%
) else (
    "%PHP_BIN%" -c "%PHP_INI%" "%PHPUNIT_PATH%" --configuration "%PHPUNIT_CONFIG%" "%TEST_DIR%" %TEAMCITY_FLAG%
)

 if errorlevel 1 (
     echo Tests fehlgeschlagen.
     exit /b 1
 ) else (
     echo Tests erfolgreich.
 )

 endlocal
