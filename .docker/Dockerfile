# syntax=docker/dockerfile:1
FROM php:8.3-fpm

# Set user/group IDs for www-data
ARG USER_ID=82
ARG GROUP_ID=82

# Install system dependencies
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
    && pecl install redis && docker-php-ext-enable redis \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && chmod +x /usr/local/bin/composer

# Configure system user
RUN groupmod -g ${GROUP_ID} www-data \
    && usermod -u ${USER_ID} -g www-data www-data

# Nginx setup
RUN mkdir -p /var/lib/nginx/body \
    && chown -R www-data:www-data /var/lib/nginx

# Create directory structure with correct permissions
RUN mkdir -p /var/www/html/storage/framework/{cache/data,sessions,views} \
    /var/www/html/storage/logs \
    /var/www/html/bootstrap/cache \
    && chown -R www-data:www-data /var/www/html \
    && find /var/www/html -type d -exec chmod 775 {} \; \
    && find /var/www/html -type f -exec chmod 664 {} \; \
    && chmod -R 777 /var/www/html/storage \
    && chmod -R 777 /var/www/html/bootstrap/cache

# Supervisor setup
RUN mkdir -p /var/log/supervisor /var/run/supervisor \
    && touch /var/log/supervisord.log \
    && chown -R www-data:www-data /var/log/supervisor /var/run/supervisor

# Workdir
WORKDIR /var/www/html

# Copy application
COPY --chown=www-data:www-data . .

# Copy configuration files
COPY --chown=www-data:www-data .docker/nginx/nginx.conf /etc/nginx/nginx.conf
COPY --chown=www-data:www-data .docker/nginx/site.conf /etc/nginx/sites-enabled/default
COPY --chown=www-data:www-data .docker/supervisor/supervisord.conf /etc/supervisor/supervisord.conf
COPY --chown=www-data:www-data .docker/supervisor/conf.d/ /etc/supervisor/conf.d/

# Update php-fpm to use TCP instead of socket
RUN sed -i 's|^listen = .*|listen = 127.0.0.1:9000|' /usr/local/etc/php-fpm.d/www.conf

# Healthcheck
HEALTHCHECK --interval=30s --timeout=3s CMD curl -f http://localhost:8083/health || exit 1

# Expose port
EXPOSE 8083

# Default command
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/supervisord.conf"]
