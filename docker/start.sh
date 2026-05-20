#!/bin/bash

# Cache config for production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run migrations
php artisan migrate --force

# Start services
/usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf