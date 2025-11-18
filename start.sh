#!/bin/sh
cd ./it-pagalbos-biletai
composer install --no-dev --optimize-autoloader
php artisan migrate --force
exec php artisan serve --host 0.0.0.0 --port $PORT
