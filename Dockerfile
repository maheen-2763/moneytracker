# =========================
# PHP + FPM Base Image
# =========================
FROM php:8.4-fpm

# =========================
# Install System Packages
# =========================
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    nginx \
    supervisor \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    libicu-dev \
    libzip-dev \
    sqlite3 \
    libsqlite3-dev \
    && docker-php-ext-configure intl \
    && docker-php-ext-install \
    pdo \
    pdo_sqlite \
    pdo_mysql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    zip \
    intl \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*


ENV COMPOSER_ALLOW_SUPERUSER=1
# =========================
# Install Composer
# =========================
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# =========================
# Set Working Directory
# =========================
WORKDIR /var/www

# =========================
# Copy Composer Files First
# (Better Docker Caching)
# =========================
COPY composer.json composer.lock ./

# =========================
# Install Dependencies
# =========================
RUN composer install \
    --no-dev \
    --prefer-dist \
    --no-interaction \
    --optimize-autoloader \
    --ignore-platform-reqs \
    --no-scripts

# =========================
# Copy Application Files
# =========================
COPY . .

# =========================
# Laravel Optimizations
# =========================
RUN php artisan package:discover --ansi || true
RUN php artisan config:cache || true
RUN php artisan route:cache || true
RUN php artisan view:cache || true

# =========================
# Permissions
# =========================
RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 storage bootstrap/cache

# =========================
# Nginx + Supervisor Config
# =========================
COPY docker/nginx.conf /etc/nginx/sites-enabled/default
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# =========================
# Startup Script
# =========================
COPY docker/start.sh /start.sh
RUN chmod +x /start.sh

# =========================
# Expose Port
# =========================
EXPOSE 8080

# =========================
# Start Services
# =========================
CMD ["/start.sh"]
