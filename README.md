# WebPortal (Laravel 11)

## Inhaltsverzeichnis
1. [Projektübersicht](#projektübersicht)
2. [Tech Stack](#tech-stack)
3. [Installation & Initialisierung](#installation--initialisierung)
4. [Scripts & Commands](#scripts--commands)
5. [Production Server Konfiguration](#nginx-konfiguration)
6. [Weiterführende Links & Ressourcen](#weiterführende-links--ressourcen)

## Projektübersicht
- Modernes Frontend mit Vite und TailwindCSS
- Queue-System für asynchrone Verarbeitung
- Integriertes Caching-System
- REST API mit Sanctum Authentication
- DigitalOcean Spaces Integration für Dateiablage

## Tech Stack

### Backend
- PHP 8.3
- Laravel 11.44.2
- MySQL als Hauptdatenbank
- Queue-System via Database Driver
- Cache-System via Database Driver

### Frontend
- TailwindCSS 3.4
- Alpine.js 3.14
- Bootstrap 5.3
- Vite 6.2 als Build-Tool

### Weiteres
- DigitalOcean Spaces für Dateiablage
- PHPUnit für Testing
- Laravel Debugbar für Entwicklung
- SMTP Mail-Versand

## Installation & Initialisierung

### Voraussetzungen
- PHP 8.3
- Composer
- Node.js 18.x
- npm
- MySQL 8.x

### erst Installation
1. Klone das Repository:
   ```shell
   git clone https://github.com/leartpro/WebPortal.git
    ```
2. Wechsle in das Projektverzeichnis:
    ```shell
    cd WebPortal
    ```
3. Installiere die Abhängigkeiten:
    ```shell
    composer install
    npm install
    ```
4. Erstelle eine Kopie der `.env.development` Datei:
    ```shell
    cp .env.development .env
    ```
   Alternativ kann auch die `.env.example` verwendet werden,
   welche dann manuell angepasst werden muss.
   ```shell
    cp .env.example .env
    ```
5. Starte den lokalen Datenbank-Server:
    ```shell
    npm run test:db:up
    ```
6. Erstelle den Applikations-Schlüssel:
    ```shell
    php artisan key:generate
    ```
7. Führe die Migrationen aus:
    ```shell
    php artisan migrate:fresh
    ```
8. Baue die Assets:
    ```shell
    npm run build
    ```9Starte den lokalen Web-Server:
    ```shell
    npm run dev
    ```

Alternativ zu 5. kann auch direkt ein Image der Test-Datenbank gebaut und gestartet werden:
```shell
  # Build the Docker image
  docker build -t test-mysql -f docker/local-test-database/LocalTestDatabase.Dockerfile docker/local-test-database
    
    # Run the container
    docker run -d -p 3306:3306 --name test-mysql-container \
      -e MYSQL_ROOT_PASSWORD=password \
      -e MYSQL_DATABASE=testing \
      test-mysql
```



## Scripts & Commands

Das Projekt bietet verschiedene NPM-Scripts für Entwicklung, Testing und Produktionsumgebung.

### NPM Scripts für die Entwicklung

Folgende NPM-Befehle stehen zur Verfügung:

- `npm run build` - Baut die Assets
- `npm run frontend` - Startet den Vite-Entwicklungsserver für Hot-Reloading
- `npm run backend` - Startet den Laravel-Entwicklungsserver
- `npm run dev` - Startet sowohl den Laravel-Server als auch Vite parallel (empfohlen für die Entwicklung)

### NPM Scripts für Datenbank-Testing

- `npm run test:db:up` - Startet den Docker-Container der Test-Datenbank (wird für `npm run dev:test` benötigt)
- `npm run test:db:down` - Stoppt den Docker-Container der Test-Datenbank

### NPM Scripts für Entwicklungswerkzeuge (Windows)

- `npm run dev:reload` - Führt eine komplette Aktualisierung der Anwendung durch (Cache leeren, Migrationen neu ausführen)
- `npm run dev:cleanup` - Bereinigt temporäre Dateien und Cache-Einträge
- `npm run dev:test` - Führt die automatisierten Tests aus, greift dabei auf die Test-Datenbank und die `.env.testing`-Konfiguration zurück

### NPM Scripts für Produktionsserver (Linux)

- `npm run prod:reload` - Aktualisiert die Anwendung auf dem Produktionsserver auf den aktuellsten Stand im Github-Repository
- `npm run prod:cleanup` - Bereinigt temporäre Dateien und optimiert den Speicherplatz auf dem Server
- `npm run prod:debugbar:enable` - Aktiviert die Laravel Debugbar für Fehlersuche im Produktionssystem
- `npm run prod:debugbar:disable` - Deaktiviert die Laravel Debugbar (sollte im Normalbetrieb deaktiviert sein)

### Composer-Script

- `composer dev` - Startet Laravel-Server, Queue-Worker und Vite-Server parallel mit farbiger Ausgabe

Alle Skripte können unabhängig vom aktuellen Verzeichnis im Projekt ausgeführt werden.

**Hinweis:** Die Implementierungen der Skripte befinden sich in den Verzeichnissen `/scripts/development` (Windows) und `/scripts/production` (Linux), 
werden aber am besten über die NPM-Scripts aufgerufen, um Pfadprobleme zu vermeiden.


## Production Server Konfiguration




