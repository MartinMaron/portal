@echo off

REM Laravel Konfigurations- und Cache-Bereinigung
call php artisan config:clear || echo Fehler ignoriert
call php artisan route:clear || echo Fehler ignoriert
call php artisan view:clear || echo Fehler ignoriert
call php artisan cache:clear || echo Fehler ignoriert

REM .env Datei kopieren
if not exist .env call copy .env.example .env || echo Fehler ignoriert

REM Abhängigkeiten installieren
call npm install || echo Fehler ignoriert
call composer install || echo Fehler ignoriert

REM Laravel App-Schlüssel generieren
call php artisan key:generate || echo Fehler ignoriert

REM Datenbankmigration mit Seeding
echo Starte Datenbankmigration...
call php artisan migrate:refresh --seed || echo Fehler ignoriert

REM Laravel parts veröffentlichen
call php artisan lang:publish || echo Fehler ignoriert
php artisan livewire:publish || echo Fehler ignoriert

REM Assets kompilieren
call npm run build || echo Fehler ignoriert

pause
