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

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer

# Copy Laravel app source code
COPY . .

# Set permissions for Laravel
RUN chmod -R 775 storage bootstrap/cache \
    && chown -R www-data:www-data .

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
