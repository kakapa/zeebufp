# syntax=docker/dockerfile:1
FROM php:8.3-fpm

# Set user/group IDs for www-data
ARG USER_ID=82
ARG GROUP_ID=82

# Install dependencies
RUN apt-get update && apt-get install -y \
    nginx \
    supervisor \
    git \
    unzip \
    zip \
    curl \
    nano \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libicu-dev \
    && docker-php-ext-install \
    pdo_mysql \
    mbstring \
    zip \
    exif \
    pcntl \
    bcmath \
    gd \
    intl \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Configure system user
RUN groupmod -g ${GROUP_ID} www-data \
    && usermod -u ${USER_ID} -g www-data www-data

# Set working directory
WORKDIR /var/www/html

# Laravel writable dirs
RUN mkdir -p storage/framework/{cache,data,sessions,views} \
    storage/logs \
    bootstrap/cache \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache

# Nginx + Supervisor setup
RUN mkdir -p /var/log/nginx /var/lib/nginx/body /run/nginx \
    && touch /var/log/nginx/access.log /var/log/nginx/error.log \
    && mkdir -p /var/log/supervisor /var/run/supervisor \
    && chown -R www-data:www-data /var/log /var/lib/nginx /run/nginx /var/run/supervisor \
    && chmod -R 755 /var/log /var/run /var/lib/nginx

# Configure PHP-FPM to use TCP socket instead of default
RUN sed -i 's|^listen = .*|listen = 127.0.0.1:9000|' /usr/local/etc/php-fpm.d/www.conf

# Copy app code with correct ownership
COPY --chown=www-data:www-data . .

# Copy nginx and supervisor config
COPY --chown=www-data:www-data .docker/nginx/nginx.conf /etc/nginx/nginx.conf
COPY --chown=www-data:www-data .docker/nginx/site.conf /etc/nginx/sites-enabled/default
COPY --chown=www-data:www-data .docker/supervisor/supervisord.conf /etc/supervisor/supervisord.conf
COPY --chown=www-data:www-data .docker/supervisor/conf.d/ /etc/supervisor/conf.d/

# Health check endpoint (Laravel route /health)
HEALTHCHECK --interval=30s --timeout=3s \
    CMD curl -f http://localhost:8083/health || exit 1

EXPOSE 8083

USER www-data
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/supervisord.conf"]
