@echo off
if not exist .env call copy .env.example .env || echo Fehler ignoriert
call npm install || echo Fehler ignoriert
call composer install || echo Fehler ignoriert
call php artisan key:generate || echo Fehler ignoriert
call php artisan lang:publish || echo Fehler ignoriert
call npm run build || echo Fehler ignoriert
pause
