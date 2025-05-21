systemctl stop nginx
systemctl stop php8.3-fpm

# Aktuelle RAM-Nutzung anzeigen
echo "Verfügbarer Speicher vor dem Build:"
free -h

# Temporäre Swap-Datei erstellen
SWAP_FILE=/swapfile
if [ ! -f "$SWAP_FILE" ]; then
    echo "Erstelle neue Swap-Datei..."
    dd if=/dev/zero of=$SWAP_FILE bs=1M count=1024  # 1GB Swap
    chmod 600 $SWAP_FILE
    mkswap $SWAP_FILE
fi
swapon $SWAP_FILE || echo "Swap konnte nicht aktiviert werden, möglicherweise bereits aktiv"
echo "Swap aktiviert:"
swapon --show


git fetch
git pull
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear
npm install
yes yes | composer install
export NODE_OPTIONS="--max-old-space-size=512"
npm run build
systemctl start php8.3-fpm
systemctl start nginx
