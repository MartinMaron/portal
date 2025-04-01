brew services restart php@8.3
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear
if [ ! -f .env ]; then
  cp .env.example .env
fi
npm install
composer install
php artisan key:generate
php artisan migrate
npm run build
