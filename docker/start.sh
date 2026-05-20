#!/bin/bash

php artisan migrate --force
php artisan storage:link || true

php-fpm -D

nginx

supervisord -c /etc/supervisor/conf.d/supervisord.conf