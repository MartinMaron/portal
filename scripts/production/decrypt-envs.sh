#!/bin/bash

set -e

if [ ! -f .env.key ]; then
  echo ".env.key nicht gefunden."
  exit 1
fi

source .env.key

if [ -z "$ENCRYPTION_KEY" ]; then
  echo "ENCRYPTION_KEY nicht gesetzt in .env.key."
  exit 1
fi

IFS=',' read -r -a SECURED_ENV_ARRAY <<< "$SECURED_ENV_FILES"

if [ -f .env ]; then
  mv .env .env.bak
  rm -f .env
fi

for ENV in "${SECURED_ENV_ARRAY[@]}"; do
  FILE=".env.${ENV}.encrypted"
  if [ ! -f "$FILE" ]; then
    echo "$FILE nicht gefunden – überspringe..."
    continue
  fi
  cp "$FILE" .env.encrypted
  php artisan env:decrypt --key="$ENCRYPTION_KEY"
  mv .env ".env.${ENV}"
  rm -f .env
  rm -f .env.encrypted
  rm -f "$FILE"
done

[ -f .env.bak ] && mv .env.bak .env
