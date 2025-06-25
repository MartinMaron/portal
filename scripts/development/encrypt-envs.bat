@echo off
setlocal enabledelayedexpansion

if not exist ".env.key" (
  echo ERROR: .env.key nicht gefunden.
  exit /b 1
)

for /f "usebackq tokens=1* delims==" %%A in (" .env.key") do (
  if /i "%%~A"=="ENCRYPTION_KEY" set "ENCRYPTION_KEY=%%~B"
  if /i "%%~A"=="SECURED_ENV_FILES" set "SECURED_ENV_FILES=%%~B"
)

if "%ENCRYPTION_KEY%"=="" (
  echo ERROR: ENCRYPTION_KEY nicht gesetzt in .env.key.
  exit /b 1
)

if "%SECURED_ENV_FILES%"=="" (
  echo ERROR: SECURED_ENV_FILES nicht gesetzt in .env.key.
  exit /b 1
)

if exist ".env" (
  move /Y ".env" ".env.bak" >nul
)

for %%E in (%SECURED_ENV_FILES%) do (
  set "ENV=%%E"
  set "FILE=.env.!ENV!"
  if not exist "!FILE!" (
    echo WARN: !FILE! nicht gefunden – ueberspringe...
    goto :continueEncrypt
  )
  echo Encrypting !FILE! ...
  copy /Y "!FILE!" ".env" >nul
  php artisan env:encrypt --key="%ENCRYPTION_KEY%"
  if exist ".env.encrypted" (
    move /Y ".env.encrypted" "!FILE!.encrypted" >nul
    echo SUCCESS: !FILE!.encrypted erzeugt
  ) else (
    echo ERROR: .env.encrypted nicht erstellt.
    exit /b 1
  )
  del /Q ".env"
  del /Q "!FILE!"
  :continueEncrypt
)

if exist ".env.bak" (
  move /Y ".env.bak" ".env" >nul
)

endlocal
echo Fertig.
