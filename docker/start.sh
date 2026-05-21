#!/bin/bash

php artisan optimize:clear || true

php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

php artisan migrate --force || true

php artisan storage:link || true

php-fpm -D
composer dump-autoload

nginx -g "daemon off;"