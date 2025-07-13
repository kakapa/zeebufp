# syntax=docker/dockerfile:1
FROM php:8.3-fpm

# Set working directory
WORKDIR /var/www/html

# Install system packages and PHP extensions
RUN apt-get update && apt-get install -y \
    nginx supervisor git unzip zip curl nano \
    libzip-dev libpng-dev libonig-dev libxml2-dev wget \
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl bcmath gd \
    && pecl install redis && docker-php-ext-enable redis

RUN apt-get update && apt-get install -y \
    libicu-dev \
    && docker-php-ext-install intl \
    && docker-php-ext-enable intl

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer

# Copy Laravel app source code
COPY . .

# Ensure required directories exist with correct permissions
RUN set -xe; \
    mkdir -p \
    /var/www/html/storage/framework/cache/data \
    /var/www/html/storage/framework/views \
    /var/www/html/storage/framework/sessions \
    /var/www/html/storage/logs \
    /var/www/html/bootstrap/cache; \
    chown -R www-data:www-data \
    /var/www/html/storage \
    /var/www/html/bootstrap/cache; \
    chmod -R 775 \
    /var/www/html/storage \
    /var/www/html/bootstrap/cache

# Copy Nginx config
COPY .docker/nginx/nginx.conf /etc/nginx/nginx.conf
COPY .docker/nginx/site.conf /etc/nginx/sites-enabled/default

# Copy Supervisor config
COPY .docker/supervisor/supervisord.conf /etc/supervisor/supervisord.conf
COPY .docker/supervisor/conf.d/ /etc/supervisor/conf.d/

# Expose HTTP port
EXPOSE 8083

# Start Supervisor (manages php-fpm, nginx, queue/horizon)
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/supervisord.conf"]
