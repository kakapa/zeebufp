FROM php:8.3-fpm

# Install system packages
RUN apt-get update && apt-get install -y \
    nginx \
    nano \
    supervisor \
    git unzip zip curl \
    libzip-dev libpng-dev libonig-dev libxml2-dev libicu-dev \
    && docker-php-ext-install \
    pdo_mysql mbstring zip exif pcntl bcmath gd intl \
    && pecl install redis && docker-php-ext-enable redis \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Setup directories
RUN mkdir -p /var/www/html/storage/framework/{cache/data,sessions,views} \
    && mkdir -p /var/www/html/storage/logs /var/www/html/bootstrap/cache \
    && mkdir -p /var/log/nginx /var/lib/nginx/body /var/run/php \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Set working dir
WORKDIR /var/www/html

# Copy app and config
COPY . .
COPY .docker/nginx/nginx.conf /etc/nginx/nginx.conf
COPY .docker/nginx/site.conf /etc/nginx/sites-enabled/default
COPY .docker/supervisor/supervisord.conf /etc/supervisor/supervisord.conf
COPY .docker/supervisor/conf.d/ /etc/supervisor/conf.d/

# Expose port
EXPOSE 8083

# Default to root
USER root

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/supervisord.conf"]
