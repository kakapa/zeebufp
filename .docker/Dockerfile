# syntax=docker/dockerfile:1
FROM php:8.3-fpm

ENV DEBIAN_FRONTEND=noninteractive \
    PUPPETEER_SKIP_CHROMIUM_DOWNLOAD=true \
    PUPPETEER_EXECUTABLE_PATH=/usr/bin/google-chrome-stable

# Install system packages and PHP extensions
RUN apt-get update && apt-get install -y \
    git curl wget unzip zip nano redis-tools iputils-ping \
    gnupg2 ca-certificates supervisor \
    libzip-dev libpng-dev libonig-dev libxml2-dev libicu-dev \
    libnss3 libnspr4 libatk1.0-0 libatk-bridge2.0-0 libcups2 libdrm2 \
    libxkbcommon0 libxcomposite1 libxdamage1 libxfixes3 libxrandr2 \
    libgbm1 libasound2 apt-transport-https \
    && docker-php-ext-install \
    pdo_mysql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    intl \
    zip \
    && pecl install redis && docker-php-ext-enable redis

# Install Node.js (v20 LTS) and latest NPM
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g npm@latest

# Install Google Chrome for Puppeteer
RUN wget -q -O - https://dl-ssl.google.com/linux/linux_signing_key.pub \
    | gpg --dearmor -o /usr/share/keyrings/google-chrome.gpg \
    && echo "deb [arch=amd64 signed-by=/usr/share/keyrings/google-chrome.gpg] http://dl.google.com/linux/chrome/deb/ stable main" \
    > /etc/apt/sources.list.d/google-chrome.list \
    && apt-get update \
    && apt-get install -y google-chrome-stable \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Set working directory
WORKDIR /var/www/html

# Copy application code
COPY . .

# Mark this directory safe for Git (fixes issues in CI/CD)
RUN git config --global --add safe.directory /var/www/html

# Install Composer
RUN curl -sS https://getcomposer.org/installer \
    | php -- --install-dir=/usr/local/bin --filename=composer

# Install PHP dependencies (Laravel)
RUN composer install --no-dev --optimize-autoloader

# Build frontend assets
RUN npm install --legacy-peer-deps \
    && npm run build || echo "⚠️ npm build failed — continuing..." \
    && npm cache clean --force

# Set correct permissions for Laravel
RUN chown -R www-data:www-data storage bootstrap/cache

# Configure Supervisor to run Laravel queue/horizon
COPY .docker/supervisor/supervisord.conf /etc/supervisor/supervisord.conf
COPY .docker/supervisor/conf.d/ /etc/supervisor/conf.d/

# Start Supervisor (process manager for queue workers, Horizon, etc.)
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/supervisord.conf"]
