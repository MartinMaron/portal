#!/bin/bash

# Logging mit Timestamps
LOGFILE="/var/www/Webhook/deploy.log"
exec > >(while read line; do echo "$(date '+%Y-%m-%d %H:%M:%S'): $line"; done | tee -a "$LOGFILE") 2>&1

echo "=== Deploy started ==="
set -e  # Exit on error
export COMPOSER_ALLOW_SUPERUSER=1
export NODE_OPTIONS="--max-old-space-size=512"

# Function for error handling
handle_error() {
    echo "ERROR: Deploy failed at step: $1"
    sudo systemctl start php8.3-fpm 2>/dev/null || true
    sudo systemctl start nginx 2>/dev/null || true
    exit 1
}

# Set trap for error handling
trap 'handle_error "Unknown step"' ERR

# Stopping services
echo "Stopping services..."
sudo systemctl stop nginx || handle_error "Stopping nginx"
sudo systemctl stop php8.3-fpm || handle_error "Stopping php-fpm"

# Swapping
free -h
SWAP_FILE=/swapfile
SWAP_FILE=/swapfile
if [ ! -f "$SWAP_FILE" ]; then
    echo "Creating swap file..."
    sudo dd if=/dev/zero of=$SWAP_FILE bs=1M count=1024
    sudo chmod 600 $SWAP_FILE
    sudo mkswap $SWAP_FILE
fi
if ! swapon --show | grep -q $SWAP_FILE; then
    sudo swapon $SWAP_FILE
    echo "Swap activated"
else
    echo "Swap already active"
fi
free -h
swapon --show

# Reloading
git fetch
git reset --hard origin/production
git pull
npm run prod:decrypt
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear
npm install
composer install --no-interaction --optimize-autoloader
npm run build
sudo chown -R deploy:www-data /var/www/WebPortal/public/build/
sudo chown -R deploy:www-data /var/www/WebPortal/node_modules/
sudo chown -R deploy:www-data /var/www/WebPortal/vendor/

# Starting
sudo systemctl start php8.3-fpm
sudo systemctl start nginx
