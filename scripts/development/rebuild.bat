echo Loesche Laravel-Caches...
call php artisan config:clear >nul 2>nul
if %errorlevel% neq 0 (
    echo --- Config-Cache bereits leer oder konnte nicht geloescht werden. ---
) else (
    echo --- Config-Cache geloescht. ---
)

call php artisan route:clear >nul 2>nul
if %errorlevel% neq 0 (
    echo --- Route-Cache bereits leer oder konnte nicht geloescht werden. ---
) else (
    echo --- Route-Cache geloescht. ---
)

call php artisan view:clear >nul 2>nul
if %errorlevel% neq 0 (
    echo --- View-Cache bereits leer oder konnte nicht geloescht werden. ---
) else (
    echo --- View-Cache geloescht. ---
)

call php artisan cache:clear >nul 2>nul
if %errorlevel% neq 0 (
    echo --- Anwendungs-Cache bereits leer oder konnte nicht geloescht werden. ---
) else (
    echo --- Anwendungs-Cache geloescht. ---
)

call npm install
call composer install
call npm run build
