# WebPortal (Laravel 11)

## Inhaltsverzeichnis
1. [Installation & Testen](#installation--testen)
2. [Scripts & Commands](#scripts--commands)
3. [Environment Konfiguration](#environment-konfiguration)
4. [Production Server Konfiguration](#production-server-konfiguration)

## Installation & Testen

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
    ```
9. Starte den lokalen Web-Server:
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

### Tests

### Voraussetzungen für das Testen

1. **Test-Datenbank**: Du benötigst eine MySQL-Datenbank namens `testing`. Diese wird automatisch über Docker eingerichtet, wenn du den entsprechenden NPM-Befehl ausführst.

2. **Umgebungsvariablen**: Das Projekt verwendet die Datei `.env.testing` für alle Test-Konfigurationen. Diese enthält bereits die passenden Einstellungen für die lokale Testdatenbank.

3. **Docker**: Für den einfachsten Testworkflow wird Docker und Docker Compose benötigt, um die Testdatenbank lokal zu starten.

#### Lokales Testen über NPM Script (empfohlen)

Die einfachste Methode, Tests auf deinem lokalen System auszuführen:

1. **Starte die Test-Datenbank**:
   ```shell
   npm run test:db:up
   ```
   Dies startet einen Docker-Container mit einer MySQL-Instanz speziell für Tests.

2. **Führe die Tests aus**:
   ```shell
   npm run dev:test
   ```
   Dieser Befehl führt alle Tests mit der richtigen Umgebungskonfiguration aus.

3. **Stoppe die Test-Datenbank** nach dem Testen:
   ```shell
   npm run test:db:down
   ```

#### Manuelles Testen über die Kommandozeile

Wenn du mehr Kontrolle über die Testausführung benötigst:

1. **Starte die Testdatenbank**:
   ```shell
   docker-compose -f docker/local-test-database/docker-compose.test-db.yml up -d
   ```

2. **Führe die Tests aus**:
   ```shell
   php artisan test
   ```
   oder mit spezifischen Optionen:
   ```shell
   php artisan test --filter=ExampleTest
   ```

3. **Ausführen einzelner Tests**:
   ```shell
   php artisan test --filter=test_example tests/Feature/ExampleTest.php
   ```

#### Continuous Integration mit GitHub Actions

Das Projekt ist mit GitHub Actions für kontinuierliche Integration eingerichtet. Bei jedem Push und Pull Request auf den `laravel11-migration`-Branch werden die Tests automatisch ausgeführt.

Die GitHub Actions-Konfiguration:
- Setzt eine MySQL-Testdatenbank auf
- Installiert alle Abhängigkeiten
- Führt Migrationen aus
- Baut die Frontend-Assets
- Führt alle Tests aus

**Hinweis**: Die Github Action ist so konfiguriert,
dass sie die Daten für die Testdatenbank aus der `.env.testing`-Datei liest.
Sollte die `.env.testing`-Datei daher verändert worden sein, 
muss gegebenenfalls auch die Action in `.github/workflows/laravel.yml` angepasst werden.

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

- `composer dev` - Startet Laravel-Server, Queue-Worker und Vite-Server parallel

### PHP-Skripte & Artisan Commands

Zusätzlich zu den NPM-Scripts bietet das Projekt auch PHP-Skripte (erreichbar über `php artisan script`):

- `php artisan script:hash` - Generiert einen Hash-Wert für ein gegebenes Passwort und zeigt das Ergebnis an

Alle Skripte können unabhängig vom aktuellen Verzeichnis im Projekt ausgeführt werden.

**Hinweis:** Die Implementierungen der Skripte befinden sich in den Verzeichnissen `/scripts/development` (Windows) und `/scripts/production` (Linux), 
werden aber am besten über die NPM-Scripts aufgerufen, um Pfadprobleme zu vermeiden.


## Environment Konfiguration


## Production Server Konfiguration

...

