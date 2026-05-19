#!/bin/bash
set -e

echo "🚀 Starting MoneyTracker..."

# Create log directories
mkdir -p /var/log/worker
mkdir -p /var/log/supervisor

# Set permissions
chown -R www-data:www-data /var/www/html/storage
chown -R www-data:www-data /var/www/html/bootstrap/cache

# Cache Laravel
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run migrations
php artisan migrate --force

# Storage link
php artisan storage:link || true

echo "✅ MoneyTracker is ready!"

exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf