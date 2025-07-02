# WebPortal (Laravel 11)

## Inhaltsverzeichnis

1. [Installation & Testen](#installation--testen)
2. [Scripts & Commands](#scripts--commands)
3. [Environment Konfiguration](#environment-konfiguration)
4. [Production Server Konfiguration](#production-server-konfiguration)

## Installation & Testen

### Voraussetzungen

- MYSQL Datenbank mit bekannten Zugangsdaten

### erst Installation

1. Lade das Repository von [Github](https://github.com/leartpro/WebPortal/archive/refs/heads/laravel11-migration.zip)
herunter und extrahiere den Zip Ordner in das gewünschte Verzeichnis.
2. Stelle sicher, dass der extrahierte Ordner "WebPortal" heißt. 
3. Installiere [Herd](https://herd.laravel.com/download/latest/windows). Herd installiert Php und Node automatisch.
4. Wechsel bei Herd zu "Sites" -> "Add Site" -> "Link existing Project"
und wähle das extrahierte Repository aus. 
Stelle sicher, dass mindestens PHP-8.4 ausgewählt ist und kein Häkchen bei HTTPS gesetzt ist.
Sollte die Website nicht direkt unter der Adresse in Herd zu sehen sein, befolge die nächsten Schritte.
5. Führe in der Powershell `Set-ExecutionPolicy -Scope CurrentUser -ExecutionPolicy Unrestricted` aus.
6. Öffne `C:\Users\yourname\.config\herd\bin\php84\php.ini` und entferne das `;` in der Zeile `;extension=ftp`.
7. Starte in Herd den PHP-Service neu.
8. Öffne den Webportal Ordner im Terminal und führe nun `copy .\.env.development .env` gefolgt von `php artisan key:generate` aus.
9. Führe `npm run dev:rebuild` aus.

Stelle nun sicher, dass die in der `.env` eingetragenen Datenbank und Spaces Konfigurationen korrekt sind.
Die Website sollte nun in Herd angezeigt werden.

Um `npm run test` bez. `npm run dev:test` ausführen zu können müssen allerdings noch die folgenden Schritte befolgt werden.
10. Installiere [Docker Desktop](https://docs.docker.com/desktop/setup/install/windows-install/)
(für die Installation muss das System einmal neu gestartet werden).
11. Starte nun die Test-Datenbank mit `npm run test:db:up`.
12. Nun führe die Tests entweder über `npm run test` oder `npm run dev:test` aus.
13. Stoppe anschließend die Test-Datenbank wieder mit `npm run test:db:down`.

Alternativ zu 11. kann auch direkt ein Image der Test-Datenbank gebaut und gestartet werden:

```shell
  docker build -t test-mysql -f docker/local-test-database/LocalTestDatabase.Dockerfile docker/local-test-database
    
  docker run -d -p 3306:3306 --name test-mysql-container \
      -e MYSQL_ROOT_PASSWORD=password \
      -e MYSQL_DATABASE=testing \
      test-mysql
```

### Tests

### Voraussetzungen für das Testen

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
- `npm run dev:test` - Führt die automatisierten Tests aus, greift dabei auf die Test-Datenbank und die `.env.testing`
  -Konfiguration zurück

#### NPM Scripts für die Umgebungsvariablen

Um zu vermeiden, dass sensible Zugangsdaten in der Versionskontrolle landen,
sind die entsprechenden Dateien standardmäßig verschlüsselt, oder in der .gitignore-Datei ausgeschlossen.

Benötigt für diese beiden Befehle wird eine `.env.key` Datei, welche ungefähr so aussehen sollte:
```dotenv
ENCRYPTION_KEY=base64:<YOUR_KEY_HERE>
SECURED_ENV_FILES=production,development
```
Diese ist von der .gitignore ausgeschlossen und darf nur lokal erstellt werden.

- `npm run dev:decrypt` - Entschlüsselt die `.env`-Datei für die lokale Entwicklung
- `npm run dev:encrypt` - Verschlüsselt die `.env`-Datei für die lokale Entwicklung

- `npm run prod:decrypt` - Entschlüsselt die `.env`-Datei für die Produktion
- `npm run prod:encrypt` - Verschlüsselt die `.env`-Datei für die Produktion

#### Composer-Script

- `composer dev` - Startet Laravel-Server, Queue-Worker und Vite-Server parallel

#### PHP-Skripte & Artisan Commands

Zusätzlich zu den NPM-Scripts bietet das Projekt auch PHP-Skripte:

- `php artisan script:hash` - Generiert einen Hash-Wert für ein gegebenes Passwort und zeigt das Ergebnis an
- `php artisan debug:js-errors` - Prüft alle Routen auf gängige JavaScript-Fehler und gibt diese aus

Alle Skripte können unabhängig vom aktuellen Verzeichnis im Projekt ausgeführt werden.

**Hinweis:** Die Implementierungen der .bat/.sh Skripte befinden sich in den Verzeichnissen `/scripts/development` (
Windows) und `/scripts/production` (Linux),
werden aber am besten über die NPM-Scripts aufgerufen, um Pfadprobleme zu vermeiden.
Die php Scripte befinden sich im Verzeichnis `/app/Console/Commands`.

### NPM Scripts für die Produktion (Linux)

- `npm run prod:reload` - Aktualisiert die Anwendung auf dem Produktionsserver auf den aktuellsten Stand im
  Github-Repository
- `npm run prod:cleanup` - Bereinigt temporäre Dateien und optimiert den Speicherplatz auf dem Server
- `npm run prod:debugbar:enable` - Aktiviert die Laravel Debugbar für Fehlersuche im Produktionssystem
- `npm run prod:debugbar:disable` - Deaktiviert die Laravel Debugbar (sollte im Normalbetrieb deaktiviert sein)

**Hinweis:** Alle Produktions-Scripts stoppen während ihrer Ausführung den Laravel-Server und starten ihn danach wieder
neu.

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
extension=ftp #muss in php.ini auf gültig gesetzt werden
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

bez. für HTTPs:

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



