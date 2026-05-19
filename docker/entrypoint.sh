#!/bin/bash
set -e

echo "🚀 Starting MoneyTracker..."

# Create log directories
mkdir -p /var/log/nginx
mkdir -p /var/log/php-fpm
mkdir -p /var/log/worker
mkdir -p /var/log/supervisor

# Set permissions
chown -R www-data:www-data /var/www/storage
chown -R www-data:www-data /var/www/bootstrap/cache

# Cache Laravel config
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run migrations
php artisan migrate --force

# Create storage link
php artisan storage:link || true

echo "✅ MoneyTracker is ready!"

# Start supervisor
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf