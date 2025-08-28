# WebPortal

## Stack
- Laravel 11
- MYSQL 8
- PHP 8.3
- Nginx
- Docker + Docker Compose

## Installation GitHub

### Branches und Rules

Das Repository ist grundsätzlich in zwei Branches unterteilt:
- `production`: Dieser Branch enthält den stabilen Code, der auf dem Produktionsserver läuft.
- `develop`: Dieser Branch enthält den aktuellen Entwicklungsstand und wird für neue Features und Bugfixes verwendet.

Der `production`-Branch ist geschützt und kann nur durch Pull Requests von `develop` aktualisiert werden.

### Actions

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

### Webhooks

Folgend Webhook ist für das Projekt eingerichtet:
```dotenv
    Payload URL = https://<YOUR_DOMAIN>/webhook/deploy.php
    Content type = application/json
    Secret = <YOUR_SECRET>
    SSL verification = Enable
    Events to trigger this webhook = Just the push event
```
Diese wird benötigt um bei jedem Push im Repository den Produktionsserver zu benachrichtigen,
damit dieser auf Updates prüfen und gegebenenfalls die Anwendung aktualisieren kann.
Mehr dazu im Abschnitt [Installation Server](#installation-server).

## Installation Client

1. Installiere [Herd](https://herd.laravel.com/download/latest/windows). Herd installiert Php und Node automatisch.
2. Lade das Repository von [Github](https://github.com/leartpro/WebPortal/archive/refs/heads/production.zip)
   herunter und extrahiere den Zip Ordner in das gewünschte Verzeichnis.
3. Stelle sicher, dass der extrahierte Ordner "WebPortal" heißt.
4. Führe in der Powershell `Set-ExecutionPolicy -Scope CurrentUser -ExecutionPolicy Unrestricted` aus.
5. Öffne `C:\Users\<YOUR_USERNAME>\.config\herd\bin\php84\php.ini` und entferne das `;` in der Zeile `;extension=ftp`.
6. Wechsel bei Herd zu `Sites` -> `Add Site` -> `Link existing Project`
   und wähle das extrahierte Repository aus.
   Stelle sicher, dass mindestens PHP-8.3 ausgewählt ist und ein Häkchen bei HTTPS gesetzt ist.
7. Erstelle eine `.env.key` Datei im Stammverzeichnis des Projekts mit folgendem Inhalt:
   ```dotenv
    ENCRYPTION_KEY=base64:<YOUR_ENCRYPTION_KEY>
    SECURED_ENV_FILES=production,development
   ```
   Ersetze `<YOUR_ENCRYPTION_KEY>` mit dem Base64-kodierten Wert, welcher zum Verschlüsseln verwendet wurde.
8. Nachdem du die `.env.key` Datei erstellt hast, kannst du nun die `.env`Dateien mit `npm run dev:decrypt` entschlüsseln.
9. Führe nun `copy .\.env.development .env` gefolgt von `php artisan key:generate` aus.
10. Führe anschließend im Projektverzeichnis folgende Befehle aus:
   ```bash
   composer install
   npm install
   php artisan storage:link
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   npm run build
   ```
11. Installiere [Docker Desktop](https://docs.docker.com/desktop/setup/install/windows-install/)
    (für die Installation muss das System einmal neu gestartet werden).
12. Starte nun die Test-Datenbank mit `npm run test:db:up`.
13. Nun führe die Tests entweder über `npm run test` oder `npm run dev:test` aus.
14. Stoppe anschließend die Test-Datenbank wieder mit `npm run test:db:down`.
15. Wenn alle Tests erfolgreich durchgelaufen sind, kannst du die Anwendung mit `npm run dev` starten, 
    sollte sie nicht bereits in Herd laufen.

Alternativ zu `13.` kann auch direkt ein Image der Test-Datenbank gebaut und gestartet werden:

```shell
  docker build -t test-mysql -f docker/local-test-database/LocalTestDatabase.Dockerfile docker/local-test-database
    
  docker run -d -p 3306:3306 --name test-mysql-container \
      -e MYSQL_ROOT_PASSWORD=password \
      -e MYSQL_DATABASE=testing \
      test-mysql
```

### lokales Testen

#### Voraussetzungen für das Testen

1. **Test-Datenbank**: Du benötigst eine MySQL-Datenbank namens `testing`. Diese wird automatisch über Docker
   eingerichtet, wenn du den entsprechenden NPM-Befehl ausführst.

2. **Umgebungsvariablen**: Das Projekt verwendet die Datei `.env.testing` für alle Test-Konfigurationen. Diese enthält
   bereits die passenden Einstellungen für die lokale Testdatenbank.

3. **Docker**: Für den einfachsten Testworkflow wird Docker und Docker Compose benötigt, um die Testdatenbank lokal zu
   starten.

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

## Scripte und Befehle

Das Projekt bietet verschiedene NPM-Scripts für Entwicklung, Testen und Produktionsumgebung.
Alle Skripte können unabhängig vom aktuellen Verzeichnis im Projekt ausgeführt werden.

**Hinweis:** Die Implementierungen der .bat/.sh Skripte befinden sich in den Verzeichnissen `/scripts/development` (
Windows) und `/scripts/production` (Linux),
werden aber am besten über die NPM-Scripts aufgerufen, um Pfadprobleme zu vermeiden.
Die php Scripte befinden sich im Verzeichnis `/app/Console/Commands`.

### NPM, Composer und Artisan Scripte für die lokale Entwicklung

- `npm run build` - Baut die Assets
- `npm run frontend` - Startet den Vite-Entwicklungsserver für Hot-Reloading
- `npm run backend` - Startet den Laravel-Entwicklungsserver
- `npm run dev` - Startet sowohl den Laravel-Server als auch Vite parallel (empfohlen für die Entwicklung)
- `npm run dev:rebuild` - Führt eine komplette Aktualisierung der Anwendung durch (Cache leeren, Assets neu bauen, etc.)
- `npm run dev:cleanup` - Bereinigt temporäre Dateien und Cache-Einträge
- `composer dev` - Startet Laravel-Server, Queue-Worker und Vite-Server parallel
- `php artisan script:hash` - Generiert einen Hash-Wert für ein gegebenes Passwort und zeigt das Ergebnis an
- `php artisan debug:js-errors` - Prüft alle Routen auf gängige JavaScript-Fehler und gibt diese aus

### NPM Scripts fürs Testen

- `npm run test:db:up` - Startet den Docker-Container der Test-Datenbank (wird für `npm run dev:test` benötigt)
- `npm run test:db:down` - Stoppt den Docker-Container der Test-Datenbank
- `npm run test` - Führt alle Tests aus (greift auf die Test-Datenbank und die `.env.testing`-Konfiguration zurück)

Der Unterschied zwischen `npm run test` und `npm run dev:test` ist,
dass zweiteres zusätzliche Performance Daten ermittelt.

### NPM Scripts für die Produktion

- `npm run prod:reload` - Aktualisiert die Anwendung auf dem Produktionsserver auf den aktuellsten Stand im
  Github-Repository
- `npm run prod:cleanup` - Bereinigt temporäre Dateien und optimiert den Speicherplatz auf dem Server
- `npm run prod:debugbar:enable` - Aktiviert die Laravel Debugbar für Fehlersuche im Produktionssystem
- `npm run prod:debugbar:disable` - Deaktiviert die Laravel Debugbar (sollte im Normalbetrieb deaktiviert sein)

**Hinweis:** Alle Produktions-Scripts stoppen während ihrer Ausführung den Laravel-Server und starten ihn danach wieder
neu.

### NPM Scripts für die Umgebungsvariablen

Um zu vermeiden, dass sensible Zugangsdaten in der Versionskontrolle landen,
sind die entsprechenden Dateien standardmäßig verschlüsselt, oder in der .gitignore-Datei ausgeschlossen.

Benötigt für diese beiden Befehle wird eine `.env.key` Datei, welche ungefähr so aussehen sollte:
```dotenv
ENCRYPTION_KEY=base64:<YOUR_KEY_HERE>
SECURED_ENV_FILES=production,development
```
Diese ist von der `.gitignore` ausgeschlossen und darf nur lokal erstellt werden.

- `npm run dev:decrypt` - Entschlüsselt die `.env`-Datei für die lokale Entwicklung
- `npm run dev:encrypt` - Verschlüsselt die `.env`-Datei für die lokale Entwicklung

- `npm run prod:decrypt` - Entschlüsselt die `.env`-Datei für die Produktion
- `npm run prod:encrypt` - Verschlüsselt die `.env`-Datei für die Produktion

### Übersicht der Umgebungsdateien

- **`.env`**: Aktuelle lokale Konfiguration (nicht im Git-Repository enthalten)
- **`.env.development`**: Vorlage für die lokale Entwicklungsumgebung
- **`.env.testing`**: Spezifische Konfiguration für das Ausführen der Tests (manuell und per GitHub Actions)
- **`.env.production`**: Konfiguration für den Produktionsserver
- **`.env.example`**: Beispielvorlage aller Umgebungsvariablen, die im Projekt verwendet werden können
- **`.env.key`**: Schlüsseldatei für die Verschlüsselung der `.env`-Dateien

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
Sollten hier Änderungen vorgenommen werden, muss gegebenenfalls auch die GitHub Action in
`.github/workflows/laravel.yml` angepasst werden.
Es wird empfohlen, die `.env.testing`-Datei nicht zu verändern,

#### .env.production (für den Produktionsserver)

Diese Konfiguration ist für die Live-Umgebung optimiert:

- Debug-Modus deaktiviert
- Fehlerprotokollierung angepasst
- Optimierte Performance-Einstellungen
- Echte API-Schlüssel und Dienste
- Tatsächliche Mail, Spaces und Datenbank-Konfiguration
- Forced HTTPS-Verbindungen

## Installation Server

### Zustand des Servers

### System- und Laufzeitumgebung

| Komponente | Version | Hinweise       |
|------------|---------|----------------|
| PHP        | 8.3.6   | CLI, FPM       |
| MySQL      | 8.0.42  |                |
| Nginx      | 1.24.0  |                |
| Node.js    | 18.19.1 |                |
| npm        | 9.2.0   |                |
| Composer   | 2.8.6   | Vom 25.02.2025 |

### Laufende Dienste

Die folgenden relevanten Dienste sind aktiv und laufen:

- nginx.service
- php8.3-fpm.service
- mysql
- cron.service
- ssh.service

### Pfade zu Konfigurationsdateien

- Nginx Konfiguration: `/etc/nginx/sites-available/WebPortal`
- PHP FPM Konfiguration: `/etc/php/8.3/fpm/php.ini`
- PHP CLI Konfiguration: `/etc/php/8.3/cli/php.ini`
- PHP-FPM Pool Konfiguration: `/etc/php/8.3/fpm/pool.d/www.conf`

### PHP-Konfigurationsparameter

```
memory_limit = -1        # Unbegrenzt (geeignet für CLI)
post_max_size = 8M       # Standard
upload_max_filesize = 2M # Standard (Beachte: könnte erhöht werden)
extension=ftp #muss in php.ini auf gültig gesetzt werden
```

### Nginx Virtual Host für WebPortal

```nginx
    server {
        server_name web.e-neko.eu www.web.e-neko.eu;
        root /var/www/WebPortal/public;
    
        add_header X-Frame-Options "SAMEORIGIN";
        add_header X-XSS-Protection "1; mode=block";
        add_header X-Content-Type-Options "nosniff";
    
        index index.php index.html;
    
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
        
        location ^~ /webhook/ {
            alias /var/www/Webhook/;
            
            location ~ \.php$ {
                include fastcgi_params;
                fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
                fastcgi_param SCRIPT_FILENAME $request_filename;
            }
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
    
        listen 443 ssl; # managed by Certbot
        ssl_certificate /etc/letsencrypt/live/web.e-neko.eu/fullchain.pem; # managed by Certbot
        ssl_certificate_key /etc/letsencrypt/live/web.e-neko.eu/privkey.pem; # managed by Certbot
        include /etc/letsencrypt/options-ssl-nginx.conf; # managed by Certbot
        ssl_dhparam /etc/letsencrypt/ssl-dhparams.pem; # managed by Certbot
    
    
    }
    server {
        listen 80;
        server_name web.e-neko.eu www.web.e-neko.eu;
        
        return 301 https://$host$request_uri;
    }
```

### Webhook

Zunächst ist ein Verzeichnis `Webhook` in `/var/www/` zu erstellen.
darin sollte dann `deploy.php` so eingefügt werden:
```php
<?php
function log_message(string $message): void {
    file_put_contents(__DIR__ . '/deploy.log', date('[Y-m-d H:i:s] ') . $message . "\n", FILE_APPEND);
}

function getSecretFromEnv(string $filepath): string {
    if (!file_exists($filepath)) {
        return '';
    }

    $lines = file($filepath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), 'SECRET=') === 0) {
            return trim(substr($line, strlen('SECRET=')));
        }
    }
    return '';
}

// === Webhook-Verarbeitung ===
$secret = getSecretFromEnv(__DIR__ . '/.env');
$signature_header = $_SERVER['HTTP_X_HUB_SIGNATURE_256'] ?? '';

if (!$signature_header) {
    http_response_code(403);
    log_message("Missing X-Hub-Signature-256 header.");
    echo "Forbidden: Missing signature.";
    exit;
}

// Rohdaten des Requests (unverarbeitet!)
$rawPayload = file_get_contents('php://input');

// Signatur berechnen
$expectedSignature = 'sha256=' . hash_hmac('sha256', $rawPayload, $secret);

// Timing-sichere Vergleichsfunktion (vermeidet Timing-Angriffe)
if (!hash_equals($expectedSignature, $signature_header)) {
    http_response_code(403);
    log_message("Signature mismatch. Expected: $expectedSignature, Received: $signature_header");
    echo "Forbidden: Invalid signature.";
    exit;
}

// Payload dekodieren
$payload = json_decode($rawPayload, true);
$ref = $payload['ref'] ?? '';

if ($ref !== 'refs/heads/production') {
    http_response_code(200);
    log_message("Ignored push: not production branch ($ref)");
    echo "Push ignored (not production branch).";
    exit;
}

// Deployment starten
log_message("Valid push to production branch. Starting deployment...");
http_response_code(200);
header('Content-Type: text/plain');
echo "Deployment triggered successfully.";

// Output an Client senden und Verbindung schließen
if (function_exists('fastcgi_finish_request')) {
    fastcgi_finish_request(); // PHP-FPM
} else {
    // Für andere SAPI
    ob_end_flush();
    flush();
}
// Systemd-Service starten
$start_output = shell_exec('sudo systemctl start webportal-deploy.service 2>&1');
$return_code = shell_exec('echo $?');

// Service-Status prüfen
$service_status = shell_exec('systemctl is-active webportal-deploy.service 2>/dev/null');

// Logging
error_log("Deploy service start output: " . $start_output);
error_log("Deploy service return code: " . $return_code);
error_log("Deploy service status: " . trim($service_status));

log_message("Deployment service started. Return code: " . trim($return_code) . ", Status: " . trim($service_status));

echo "Deployment triggered.";
```

Die GitHub-Webhooks werden mit einem Secret signiert.
Erstelle im gleichen Verzeichnis eine `.env`-Datei und trage dort das Secret ein:
```shell
echo "WEBHOOK_SECRET=DeinGeheimnisToken" | sudo tee /var/www/Webhook/.env
```
Stelle sicher, dass die `.env`-Datei nur vom Webserver lesbar ist
(z.B. mit `sudo chown www-data:www-data /var/www/Webhook/.env` und `sudo chmod 640 /var/www/Webhook/.env`).

Systemd Service erstellen mit `touch /etc/systemd/system/webportal-deploy.service` und folgendem Inhalt:
```init
[Unit]
Description=WebPortal Deployment Service
After=network.target

[Service]
Type=oneshot
User=deploy
Group=deploy
WorkingDirectory=/var/www/WebPortal
Environment=COMPOSER_ALLOW_SUPERUSER=1
Environment=NODE_OPTIONS=--max-old-space-size=512
Environment=PATH=/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin
ExecStart=/usr/bin/npm run prod:reload
StandardOutput=append:/var/www/Webhook/deploy_systemd.log
StandardError=append:/var/www/Webhook/deploy_systemd.log
TimeoutStartSec=600
RemainAfterExit=no

[Install]
WantedBy=multi-user.target
```
Aktiviere den Service und starte ihn:
```shell
sudo systemctl daemon-reload
sudo systemctl enable webportal-deploy.service
```

Anschließend log-Rotation des Deployments in `/var/www/Webhook/deploy.log`:
```shell
touch /etc/logrotate.d/webportal-deploy
```
und füge folgenden Inhalt ein:
```logrotate
/var/www/Webhook/deploy_systemd.log {
    daily
    missingok
    rotate 7
    compress
    delaycompress
    notifempty
    create 644 deploy deploy
}
```

Damit www-data das Webhook-Skript ausführen und Logs schreiben kann, setze den Besitzer und die Rechte:
```shell
sudo chown -R www-data:www-data /var/www/Webhook
sudo find /var/www/Webhook -type f -exec chmod 640 {} \;
sudo find /var/www/Webhook -type d -exec chmod 750 {} \;
```
Dadurch hat der Webserver (`www-data`) Lese-/Schreibzugriff auf die Dateien und Verzeichnisse im Webhook-Ordner.
Richte nun den System-Benutzer `deploy` ein (falls noch nicht vorhanden):
```shell
sudo useradd -m -s /bin/bash deploy
```
Setze deploy als Eigentümer des Projektordners:
```shell
sudo chown -R deploy:www-data /var/www/WebPortal/public/build/
sudo chown -R deploy:www-data /var/www/WebPortal/node_modules/
sudo chown -R deploy:www-data /var/www/WebPortal/vendor/
```
Dadurch hat deploy volle Zugriffsrechte auf das WebPortal-Verzeichnis für das Deployment.
Ermögliche www-data, den Befehl npm run prod:reload als deploy-User ohne Passwort auszuführen.
Füge in `/etc/sudoers.d` (z.B. via `sudo visudo`) folgendes hinzu:
```shell
Defaults:www-data !requiretty

www-data ALL=(deploy) NOPASSWD: /usr/bin/npm

Defaults:deploy !requiretty

deploy ALL=(root) NOPASSWD: \
           /usr/bin/systemctl start nginx, \
           /usr/bin/systemctl stop nginx, \
           /usr/bin/systemctl start php8.3-fpm, \
           /usr/bin/systemctl stop php8.3-fpm, \
           /usr/sbin/swapon, \
           /sbin/mkswap, \
           /usr/bin/dd, \
           /usr/bin/chown, \
           /usr/bin/chmod

www-data ALL=(root) NOPASSWD: /usr/bin/systemctl start webportal-deploy.service
```

Erzeuge (oder importiere) SSH-Schlüssel für den Benutzer deploy,
damit dieser per SSH auf GitHub (nur Lesezugriff) zugreifen kann:
```shell
sudo -u deploy mkdir -p /home/deploy/.ssh
sudo -u deploy ssh-keygen -t ed25519 -f /home/deploy/.ssh/id_ed25519 -N "" -C "deployment-key"
```
Kopiere den öffentlichen Schlüssel (`/home/deploy/.ssh/id_ed25519.pub`) als Deploy-Key in dein GitHub-Repository.
Setze die Dateiberechtigungen korrekt:
```shell
sudo chown -R deploy:deploy /home/deploy/.ssh
sudo chmod 700 /home/deploy/.ssh
sudo chmod 600 /home/deploy/.ssh/id_ed25519
sudo chmod 644 /home/deploy/.ssh/id_ed25519.pub
```
Das Skript protokolliert seine Ausgabe in `/var/www/Webhook/deploy.log`. Erstelle die Logdatei und setze die Rechte:
```shell
sudo touch /var/www/Webhook/deploy.log
sudo chown deploy:www-data /var/www/Webhook/deploy.log
sudo chmod 664 /var/www/Webhook/deploy.log
```
Überwache den Inhalt des Logs z.B. mit `tail -f /var/www/Webhook/deploy.log`, um den Deployment-Prozess zu verfolgen.
