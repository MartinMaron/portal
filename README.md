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
- Docker und Docker Compose

### erst Installation
1. Klone das Repository:
   ```shell
   git clone https://github.com/leartpro/WebPortal.git
    ```
2. Wechsel in das Projektverzeichnis:
    ```shell
    cd WebPortal
    ```
3. Installiere die Abhängigkeiten:
    ```shell
    composer install
    npm install
    ```
4. Erstelle eine Kopie der `.env.development` Datei, oder alternativ der `.env.example`
   (erfordert manuelle Anpassung):
    ```shell
    cp .env.development .env
    ```
   bez.
   ```shell
    cp .env.example .env
    ```
   **Hinweis:** Wichtig ist, dass gultige Datenbank-Zugangsdaten in der `.env`-Datei eingetragen werden.
5. Erstelle den Applikations-Schlüssel:
    ```shell
    php artisan key:generate
    ```
6. Baue die Assets:
    ```shell
    npm run build
    ```
7. Starte den lokalen Datenbank-Server:
    ```shell
    npm run test:db:up
    ```
8. Führe die Tests aus:
    ```shell
    npm run dev:test
    ```
9. Stoppe die Test-Datenbank:
    ```shell
    npm run test:db:down
    ```
10. Führe die Migration auf der Datenbank aus:
    ```shell
    php artisan migrate:fresh --seed
    ```
11. Starte den Laravel-Developments-Server:
    ```shell
    npm run dev
    ```

Alternativ zu 7. kann auch direkt ein Image der Test-Datenbank gebaut und gestartet werden:
```shell
  docker build -t test-mysql -f docker/local-test-database/LocalTestDatabase.Dockerfile docker/local-test-database
    
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
    Dies stoppt den Docker-Container, der die Testdatenbank bereitstellt.

#### Manuelles Testen über die Kommandozeile

Wenn du mehr Kontrolle über die Testausführung benötigst:

1. **Starte die Testdatenbank**:
   ```shell
   docker-compose -f docker/local-test-database/docker-compose.test-db.yml up -d
   ```
   Dieser Befehl muss im root-Verzeichnis des Projekts ausgeführt werden.

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

Das Projekt ist mit GitHub Actions für kontinuierliche Integration eingerichtet. 
Bei jedem Push und Pull Request auf den `laravel11-migration`-Branch werden die Tests automatisch ausgeführt.

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

Das Projekt bietet verschiedene NPM-Scripts für Entwicklung, Testen und Produktionsumgebung.

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

- `npm run dev:rebuild` - Führt eine komplette Aktualisierung der Anwendung durch (Cache leeren, Assets neu bauen, etc.)
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

**Hinweis:** Die Implementierungen der .bat/.sh Skripte befinden sich in den Verzeichnissen `/scripts/development` (Windows) und `/scripts/production` (Linux), 
werden aber am besten über die NPM-Scripts aufgerufen, um Pfadprobleme zu vermeiden.
Die php Scripte befinden sich im Verzeichnis `/app/Console/Commands`.


## Environment Konfiguration

Das Projekt verwendet verschiedene Umgebungskonfigurationen, welche über spezifische `.env`-Dateien gesteuert werden.

### Übersicht der Umgebungsdateien

- **`.env`**: Aktuelle lokale Konfiguration (nicht im Git-Repository enthalten)
- **`.env.development`**: Vorlage für die lokale Entwicklungsumgebung
- **`.env.testing`**: Spezifische Konfiguration für das Ausführen der Tests (manuell und per GitHub Actions)
- **`.env.production`**: Konfiguration für den Produktionsserver
- **`.env.example`**: Beispielvorlage alle Umgebungsvariablen, die im Projekt verwendet werden

### Zweck der unterschiedlichen Konfigurationsdateien

#### .env.development (für lokale Entwicklung)

Diese Datei enthält Einstellungen, die optimal für die lokale Entwicklung angepasst sind:
- Debug-Modus aktiviert
- Lokale Datenbankkonfiguration
- Laravel Debugbar aktiviert
- E-Mail-Versand im log-Modus (keine echten E-Mails werden versandt)

Beispiel für eine `.env.development` Datei:

```dotenv
APP_NAME="WebPortal (Development)"
APP_ENV=local
APP_DEBUG=true
DEBUGBAR_ENABLED=true
APP_URL=http://localhost:8000
VITE_DEV_SERVER_URL=http://localhost:5173

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=webportal_dev
DB_USERNAME=laravel
DB_PASSWORD=secret

MAIL_MAILER=
## Production Server Konfiguration

```

#### .env.testing (für die Tests)

Diese Datei ist speziell für die Ausführung von Tests optimiert:
- Verwendet eine separate Test-Datenbank
- Deaktiviert bestimmte Features, die Tests verlangsamen würden
- Optimiert für Geschwindigkeit und Wiederholbarkeit
- Sollte weitgehend unverändert bleiben

**Hinweis**: Auch wenn diese nicht aktiv (daher in die .env kopiert) ist, 
wird sie dennoch beim Ausführen der Tests verwendet.
Die `.env.testing`-Datei wird auch von den GitHub Actions verwendet.
Sollten hier Änderungen vorgenommen werden, muss gegebenenfalls auch die GitHub Action in `.github/workflows/laravel.yml` angepasst werden.

#### .env.production (für den Produktionsserver)

Diese Konfiguration ist für die Live-Umgebung optimiert:
- Debug-Modus deaktiviert
- Fehlerprotokollierung angepasst
- Optimierte Performance-Einstellungen
- Echte API-Schlüssel und Dienste
- Tatsächliche Mail und Datenbank-Konfiguration

