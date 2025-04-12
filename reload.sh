systemctl stop nginx
systemctl stop php8.3-fpm
git fetch
git pull
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear
npm install
composer install
npm run build
systemctl start php8.3-fpm
systemctl start nginx
