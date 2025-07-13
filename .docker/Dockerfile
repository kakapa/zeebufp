# syntax=docker/dockerfile:1
FROM php:8.3-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    nginx supervisor git unzip zip curl \
    libzip-dev libpng-dev libonig-dev libxml2-dev libicu-dev \
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl bcmath gd intl \
    && pecl install redis && docker-php-ext-enable redis

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer \
    && chmod +x /usr/local/bin/composer

# Create directory structure with correct permissions
RUN mkdir -p /var/www/html/storage/framework/{cache/data,sessions,views} \
    /var/www/html/storage/logs \
    /var/www/html/bootstrap/cache \
    && chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

WORKDIR /var/www/html

# Copy application files with correct ownership
COPY --chown=www-data:www-data . .

# Copy configurations
COPY .docker/nginx/nginx.conf /etc/nginx/nginx.conf
COPY .docker/nginx/site.conf /etc/nginx/sites-enabled/default
COPY .docker/supervisor/supervisord.conf /etc/supervisor/supervisord.conf
COPY .docker/supervisor/conf.d/ /etc/supervisor/conf.d/

EXPOSE 8083

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/supervisord.conf"]
