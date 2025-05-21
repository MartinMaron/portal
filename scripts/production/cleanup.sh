#!/usr/bin/env bash
set +e
export COMPOSER_ALLOW_SUPERUSER=1
echo "****************************"
echo "Stopping Server..."
echo "****************************"

systemctl stop nginx
systemctl stop php8.3-fpm

echo "Loesche Caches"
php artisan config:clear || echo "Config-Cache konnte nicht gelöscht werden."
php artisan route:clear || echo "Route-Cache konnte nicht gelöscht werden."
php artisan view:clear || echo "View-Cache konnte nicht gelöscht werden."
php artisan cache:clear || echo "Anwendungs-Cache konnte nicht gelöscht werden."

if [[ -d vendor ]]; then
  echo "Loesche Ordner 'vendor'..."
  rm -rf vendor || echo "Konnte 'vendor' nicht vollständig löschen."
fi

if [[ -d node_modules ]]; then
  echo "Loesche Ordner 'node_modules'..."
  rm -rf node_modules || echo "Konnte 'node_modules' nicht vollständig löschen."
fi

if [[ -d storage/debugbar ]]; then
  echo "Loesche Debugbar-Ordner 'storage/debugbar'..."
  rm -rf storage/debugbar || echo "Konnte 'storage/debugbar' nicht vollständig löschen."
fi

if [[ -f .phpunit.result.cache ]]; then
  echo "Loesche PHPUnit Cache '.phpunit.result.cache'..."
  rm -f .phpunit.result.cache || echo "Konnte '.phpunit.result.cache' nicht löschen."
fi

if [[ -f public/hot ]]; then
  echo "Loesche Datei 'public/hot'..."
  rm -f public/hot || echo "Konnte 'public/hot' nicht löschen."
fi

if [[ -f storage/logs/laravel.log ]]; then
  echo "Loesche Logdatei 'storage/logs/laravel.log'..."
  rm -f storage/logs/laravel.log || echo "Konnte 'storage/logs/laravel.log' nicht löschen."
fi

if [[ -f composer.lock ]]; then
  echo "Loesche 'composer.lock'..."
  rm -f composer.lock || echo "Konnte 'composer.lock' nicht löschen."
fi

if [[ -f package-lock.json ]]; then
  echo "Loesche 'package-lock.json'..."
  rm -f package-lock.json || echo "Konnte 'package-lock.json' nicht löschen."
fi

if [[ -d public/build ]]; then
  echo "Loesche Ordner 'public/build'..."
  rm -rf public/build || echo "Konnte 'public/build' nicht vollständig löschen."
fi

if [[ -d public/storage ]]; then
  echo "Loesche Ordner 'public/storage'..."
  rm -rf public/storage || echo "Konnte 'public/storage' nicht vollständig löschen."
fi

echo "****************************"
echo "Reinstalling Assets..."
echo "****************************"

npm install
composer install --no-interaction
npm run build

echo "****************************"
echo "Starting Server..."
echo "****************************"

systemctl start php8.3-fpm
systemctl start nginx

echo "****************************"
echo "Cleanup completed"
echo "****************************"
