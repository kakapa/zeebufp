# syntax=docker/dockerfile:1
FROM php:8.3-apache

# Non-interactive setup
ENV DEBIAN_FRONTEND=noninteractive \
    PUPPETEER_SKIP_CHROMIUM_DOWNLOAD=true \
    PUPPETEER_EXECUTABLE_PATH=/usr/bin/google-chrome-stable

# Install system dependencies & Chrome dependencies
RUN apt-get update && apt-get install -y --no-install-recommends \
    apt-transport-https \
    wget \
    git \
    curl \
    gnupg2 \
    zip \
    unzip \
    supervisor \
    pkg-config \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libicu-dev \
    # Chrome dependencies
    libnss3 \
    libnspr4 \
    libatk1.0-0 \
    libatk-bridge2.0-0 \
    libcups2 \
    libdrm2 \
    libxkbcommon0 \
    libxcomposite1 \
    libxdamage1 \
    libxfixes3 \
    libxrandr2 \
    libgbm1 \
    libasound2 \
    ca-certificates \
    # Node.js (Latest LTS from official source)
    && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    # Install latest stable NPM manually
    && npm install -g npm@latest \
    # Install Google Chrome
    && wget -q -O - https://dl-ssl.google.com/linux/linux_signing_key.pub \
    | gpg --dearmor -o /usr/share/keyrings/google-chrome.gpg \
    && echo "deb [arch=amd64 signed-by=/usr/share/keyrings/google-chrome.gpg] http://dl.google.com/linux/chrome/deb/ stable main" \
    > /etc/apt/sources.list.d/google-chrome.list \
    && apt-get update \
    && apt-get install -y google-chrome-stable \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install \
    pdo_mysql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    intl \
    zip

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Copy Apache virtual host config
COPY .docker/vhost.conf /etc/apache2/sites-available/000-default.conf

# Set working directory
WORKDIR /var/www/html

# Trust the working directory for git
RUN git config --global --add safe.directory /var/www/html

# Copy dependency files early for layer caching
COPY composer.json composer.lock ./
COPY package.json package-lock.json ./
COPY vite.config.js ./
COPY app/Helpers/helper.php app/Helpers/helper.php

# Install Composer
RUN curl -sS https://getcomposer.org/installer \
    | php -- --install-dir=/usr/local/bin --filename=composer

# Install PHP dependencies
RUN composer install --no-dev --no-scripts --no-autoloader

# Copy the rest of your application
COPY . .

# Install Node dependencies & build frontend
RUN npm install --legacy-peer-deps \
    && npm run build || echo "⚠️ Build failed or skipped due to missing index.html, continuing..." \
    && npm cache clean --force

# Run full install with scripts
RUN composer install --no-dev --optimize-autoloader

# Set correct permissions
RUN chown -R www-data:www-data \
    /var/www/html/storage \
    /var/www/html/bootstrap/cache

# Copy Supervisor config
COPY .docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Expose Apache
EXPOSE 80

# Run Apache + Laravel queue via supervisor
CMD ["/usr/bin/supervisord", "--nodaemon", "--configuration", "/etc/supervisor/conf.d/supervisord.conf"]
