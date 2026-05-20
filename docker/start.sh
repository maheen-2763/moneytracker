#!/bin/bash

php artisan migrate --force

php-fpm -D

nginx

supervisord -c /etc/supervisor/conf.d/supervisord.conf