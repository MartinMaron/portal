#!/bin/bash
systemctl stop nginx
systemctl stop php8.3-fpm
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear
composer install
npm run build
systemctl start php8.3-fpm
systemctl start nginx
