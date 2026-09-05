FROM php:8.3-apache

# Install system packages + PHP extensions
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libzip-dev \
    libpq-dev \
    libsqlite3-dev \
    sqlite3 \
    && docker-php-ext-install \
        pdo \
        pdo_sqlite \
        pdo_pgsql \
        pgsql \
        zip \
    && rm -rf /var/lib/apt/lists/*

# Apache rewrite
RUN a2enmod rewrite

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Node.js
RUN curl -fsSL https://deb.nodesource.com/setup_22.x | bash - \
    && apt-get install -y nodejs

WORKDIR /var/www/html

# Copy project
COPY . .

# Laravel dependencies
RUN composer install --no-dev --optimize-autoloader

# Frontend build
RUN npm install
RUN npm run build

# Runtime directories and permissions
RUN mkdir -p storage/framework/cache/data \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Apache document root -> public
RUN sed -ri -e 's!/var/www/html!/var/www/html/public!g' \
    /etc/apache2/sites-available/*.conf

# Clear Laravel cache
RUN php artisan optimize:clear || true

# Render supplies PORT (normally 10000). Apache must listen on that port.
# Migrations and seed run at container startup so Laravel uses the configured
# PostgreSQL database instead of creating a database inside the Docker image.
EXPOSE 10000

CMD ["sh", "-c", "php artisan migrate --force && php artisan db:seed --force && PORT=${PORT:-10000}; sed -ri \"s/^Listen [0-9]+/Listen ${PORT}/\" /etc/apache2/ports.conf; sed -ri \"s/<VirtualHost \\*:80>/<VirtualHost *:${PORT}>/g\" /etc/apache2/sites-available/*.conf; exec apache2-foreground"]
