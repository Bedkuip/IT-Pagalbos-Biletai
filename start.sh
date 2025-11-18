#!/bin/sh
cd IT-Pagalbos-Biletai
composer install --no-dev --optimize-autoloader
php artisan migrate --force
exec php artisan serve --host 0.0.0.0 --port $PORT
