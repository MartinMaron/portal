# WebPortal (Laravel 11)

## Inhaltsverzeichnis
1. [Projektübersicht](#projektübersicht)
2. [Installation & Initialisierung](#installation--initialisierung)
3. [Deployment & Staging/Produktion](#deployment--stagingproduktion)
4. [Nginx Konfiguration](#nginx-konfiguration)
5. [Wichtige Scripts](#wichtige-scripts)
6. [Backup & Wiederherstellung](#backup--wiederherstellung)
7. [Weiterführende Links & Ressourcen](#weiterführende-links--ressourcen)

## Projektübersicht
Dieses Repository enthält die **WebPortal**-Anwendung auf Basis von Laravel 11. Es beinhaltet:
- Modernes Frontend-Build mit **Vite**
- CORS-freie Produktionsauslieferung via **Nginx**
- PHPUnit Testing

## Installation & Initialisierung
Führe im Projekt-Root folgende Schritte aus:

```shell
# (Optional) Mac: PHP-Service neu starten
brew services restart php@8.3

# Laravel Caches leeren
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

# .env erzeugen
if [ ! -f .env ]; then
  cp .env.production .env
fi

# Dependencies installieren
npm install
composer install

# Applikations-Schlüssel erzeugen
php artisan key:generate

# Assets bauen für Production
npm run build
```

Oder auf Windows:
```powershell
# (Optional) Windows: PHP-Service neu starten
call php artisan config:clear 
call php artisan route:clear 
call php artisan view:clear 
call php artisan cache:clear 
if not exist .env call copy .env.example .env 
call npm install 
call composer install 
call php artisan key:generate 
call npm run build 
```

