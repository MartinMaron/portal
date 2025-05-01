brew services restart php@8.3
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear
if [ ! -f .env ]; then
  cp .env.production .env
fi
npm install
composer install
php artisan key:generate
npm run build
