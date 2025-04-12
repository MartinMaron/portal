@echo off
call php artisan config:clear || echo Fehler ignoriert
call php artisan route:clear || echo Fehler ignoriert
call php artisan view:clear || echo Fehler ignoriert
call php artisan cache:clear || echo Fehler ignoriert
if not exist .env call copy .env.example .env || echo Fehler ignoriert
call npm install || echo Fehler ignoriert
call composer install || echo Fehler ignoriert
call php artisan key:generate || echo Fehler ignoriert
echo Starte Datenbankmigration...
call php artisan migrate:fresh --seed || echo Fehler ignoriert
call php artisan lang:publish || echo Fehler ignoriert
call npm run build || echo Fehler ignoriert
pause
