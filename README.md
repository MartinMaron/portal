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
    npm run test
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
   npm run test
   ```
    oder alternativ
    ```shell
    npm run dev:test
    ```
   Diese Befehle führen alle Tests mit der richtigen Umgebungskonfiguration aus.
   Der Unterschied zwischen diesen beiden Befehlen wird in [#Scripts & Commands](#scripts--commands) erklärt.

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

**Hinweis:** Die Github Action ist so konfiguriert,
dass sie die Daten für die Testdatenbank aus der `.env.testing`-Datei liest.
Sollte die `.env.testing`-Datei daher verändert worden sein, 
muss gegebenenfalls auch die Action in `.github/workflows/laravel.yml` angepasst werden.

## Scripts & Commands

Das Projekt bietet verschiedene NPM-Scripts für Entwicklung, Testen und Produktionsumgebung.

### NPM Scripts für die Entwicklung (Windows)

Folgende NPM-Befehle stehen zur Verfügung:

- `npm run build` - Baut die Assets
- `npm run frontend` - Startet den Vite-Entwicklungsserver für Hot-Reloading
- `npm run backend` - Startet den Laravel-Entwicklungsserver
- `npm run dev` - Startet sowohl den Laravel-Server als auch Vite parallel (empfohlen für die Entwicklung)

#### NPM Scripts fürs Testen

- `npm run test:db:up` - Startet den Docker-Container der Test-Datenbank (wird für `npm run dev:test` benötigt)
- `npm run test:db:down` - Stoppt den Docker-Container der Test-Datenbank
- `npm run test` - Führt alle Tests aus (greift auf die Test-Datenbank und die `.env.testing`-Konfiguration zurück)

Der Unterschied zwischen `npm run test` und `npm run dev:test` ist, 
dass zweiteres zusätzliche Performance Daten ermittelt.

#### NPM Scripts für Entwicklungswerkzeuge

- `npm run dev:rebuild` - Führt eine komplette Aktualisierung der Anwendung durch (Cache leeren, Assets neu bauen, etc.)
- `npm run dev:cleanup` - Bereinigt temporäre Dateien und Cache-Einträge
- `npm run dev:test` - Führt die automatisierten Tests aus, greift dabei auf die Test-Datenbank und die `.env.testing`-Konfiguration zurück

#### Composer-Script

- `composer dev` - Startet Laravel-Server, Queue-Worker und Vite-Server parallel

#### PHP-Skripte & Artisan Commands

Zusätzlich zu den NPM-Scripts bietet das Projekt auch PHP-Skripte (erreichbar über `php artisan script`):

- `php artisan script:hash` - Generiert einen Hash-Wert für ein gegebenes Passwort und zeigt das Ergebnis an

Alle Skripte können unabhängig vom aktuellen Verzeichnis im Projekt ausgeführt werden.

**Hinweis:** Die Implementierungen der .bat/.sh Skripte befinden sich in den Verzeichnissen `/scripts/development` (Windows) und `/scripts/production` (Linux),
werden aber am besten über die NPM-Scripts aufgerufen, um Pfadprobleme zu vermeiden.
Die php Scripte befinden sich im Verzeichnis `/app/Console/Commands`.

### NPM Scripts für die Produktion (Linux)

- `npm run prod:reload` - Aktualisiert die Anwendung auf dem Produktionsserver auf den aktuellsten Stand im Github-Repository
- `npm run prod:cleanup` - Bereinigt temporäre Dateien und optimiert den Speicherplatz auf dem Server
- `npm run prod:debugbar:enable` - Aktiviert die Laravel Debugbar für Fehlersuche im Produktionssystem
- `npm run prod:debugbar:disable` - Deaktiviert die Laravel Debugbar (sollte im Normalbetrieb deaktiviert sein)

**Hinweis:** Alle Produktions-Scripts stoppen während ihrer Ausführung den Laravel-Server und starten ihn danach wieder neu.

## Environment Konfiguration

Das Projekt verwendet verschiedene Umgebungskonfigurationen, welche über spezifische `.env`-Dateien gesteuert werden.

### Übersicht der Umgebungsdateien

- **`.env`**: Aktuelle lokale Konfiguration (nicht im Git-Repository enthalten)
- **`.env.development`**: Vorlage für die lokale Entwicklungsumgebung
- **`.env.testing`**: Spezifische Konfiguration für das Ausführen der Tests (manuell und per GitHub Actions)
- **`.env.production`**: Konfiguration für den Produktionsserver
- **`.env.example`**: Beispielvorlage aller Umgebungsvariablen, die im Projekt verwendet werden können

### Zweck der unterschiedlichen Konfigurationsdateien

#### .env.development (für lokale Entwicklung)

Diese Datei enthält Einstellungen, die optimal für die lokale Entwicklung angepasst sind:
- Debug-Modus aktiviert
- Lokale Datenbankkonfiguration
- Laravel Debugbar aktiviert
- E-Mail-Versand im log-Modus (keine echten E-Mails werden versandt)

#### .env.testing (für die Tests)

Diese Datei ist speziell für die Ausführung von Tests optimiert:
- Verwendet eine separate Test-Datenbank
- Deaktiviert bestimmte Features, die Tests verlangsamen würden
- Optimiert für Geschwindigkeit und Wiederholbarkeit
- Sollte weitgehend unverändert bleiben

**Hinweis**: Auch wenn diese nicht aktiv (daher in die .env kopiert) ist, 
wird sie dennoch beim Ausführen der Tests verwendet und auch von der GitHub Actions verwendet.
Sollten hier Änderungen vorgenommen werden, muss gegebenenfalls auch die GitHub Action in `.github/workflows/laravel.yml` angepasst werden.
Es wird empfohlen, die `.env.testing`-Datei nicht zu verändern,

#### .env.production (für den Produktionsserver)

Diese Konfiguration ist für die Live-Umgebung optimiert:
- Debug-Modus deaktiviert
- Fehlerprotokollierung angepasst
- Optimierte Performance-Einstellungen
- Echte API-Schlüssel und Dienste
- Tatsächliche Mail, Spaces und Datenbank-Konfiguration
- Forced HTTPS-Verbindungen

## Production Server Konfiguration

### System- und Laufzeitumgebung

| Komponente | Version | Hinweise       |
|------------|---------|----------------|
| PHP        | 8.3.6   | CLI, FPM       |
| MySQL      | 8.0.42  |                |
| Nginx      | 1.24.0  |                |
| Node.js    | 18.19.1 |                |
| npm        | 9.2.0   |                |
| Composer   | 2.8.6   | Vom 25.02.2025 |

### PHP-Konfiguration

#### Installierte PHP-Module
- mbstring
- openssl
- pdo_mysql
- tokenizer
- xml
- ctype
- json
- curl
- dom
- fileinfo
- filter
- hash
- pcre
- session
- SPL
- zip
- zlib
- Zend OPcache

#### PHP-Konfigurationsparameter
```
memory_limit = -1        # Unbegrenzt (geeignet für CLI)
post_max_size = 8M       # Standard
upload_max_filesize = 2M # Standard (Beachte: könnte erhöht werden)
```

### Webserver-Konfiguration

#### Nginx Virtual Host für WebPortal
```nginx
server {
    listen 80;
    server_name 164.92.137.114;
    root /var/www/WebPortal/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-XSS-Protection "1; mode=block";
    add_header X-Content-Type-Options "nosniff";

    index index.html index.php;

    error_page 404 /index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
 
    location /build/ {
        alias /var/www/WebPortal/public/build/;
        add_header Cache-Control "public";
        expires max;
        access_log off;
    }

    location ~* \.(js|css|png|jpg|jpeg|gif|svg|ico|woff2|woff|ttf)$ {
        root /var/www/WebPortal/public;
        try_files $uri $uri/ =404;
        access_log off;
        expires max;
        add_header Cache-Control "public";
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

### Laufende Dienste

Die folgenden relevanten Dienste sind aktiv und laufen:
- nginx.service
- php8.3-fpm.service
- mysql (implizit, da mysql funktioniert)
- cron.service
- ssh.service

### Pfade zu Konfigurationsdateien

- Nginx Konfiguration: `/etc/nginx/sites-available/WebPortal`
- PHP FPM Konfiguration: `/etc/php/8.3/fpm/php.ini`
- PHP CLI Konfiguration: `/etc/php/8.3/cli/php.ini`
- PHP-FPM Pool Konfiguration: `/etc/php/8.3/fpm/pool.d/www.conf`



