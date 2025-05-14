#!/usr/bin/env bash
set -e

echo "****************************"
echo "Lösche alle build Dateien..."
echo "****************************"

# Lösche vendor
if [[ -d vendor ]]; then
  echo "Lösche Ordner 'vendor'..."
  rm -rf vendor
fi

# Lösche node_modules
if [[ -d node_modules ]]; then
  echo "Lösche Ordner 'node_modules'..."
  rm -rf node_modules
fi

# Lösche Debugbar
if [[ -d storage/debugbar ]]; then
  echo "Lösche Debugbar-Ordner 'storage/debugbar'..."
  rm -rf storage/debugbar
fi

# Lösche PHPUnit Cache
if [[ -f .phpunit.result.cache ]]; then
  echo "Lösche PHPUnit Cache '.phpunit.result.cache'..."
  rm -f .phpunit.result.cache
fi

# Lösche public/hot
if [[ -f public/hot ]]; then
  echo "Lösche Datei 'public/hot'..."
  rm -f public/hot
fi

# Lösche laravel.log
if [[ -f storage/logs/laravel.log ]]; then
  echo "Lösche Logdatei 'storage/logs/laravel.log'..."
  rm -f storage/logs/laravel.log
fi

# Lösche composer.lock
if [[ -f composer.lock ]]; then
  echo "Lösche 'composer.lock'..."
  rm -f composer.lock
fi

# Lösche package-lock.json
if [[ -f package-lock.json ]]; then
  echo "Lösche 'package-lock.json'..."
  rm -f package-lock.json
fi

# Lösche public/build
if [[ -d public/build ]]; then
  echo "Lösche Ordner 'public/build'..."
  rm -rf public/build
fi

# Lösche public/storage
if [[ -d public/storage ]]; then
  echo "Lösche Ordner 'public/storage'..."
  rm -rf public/storage
fi

echo "Cleanup fertig."
