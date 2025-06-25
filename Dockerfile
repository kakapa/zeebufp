# syntax=docker/dockerfile:1
FROM php:8.3-apache

# avoid any interactive prompts
ENV DEBIAN_FRONTEND=noninteractive

# 1. Install system dependencies, Node.js, Supervisor, and Chrome dependencies
RUN apt-get update \
    && apt-get install -y --no-install-recommends \
    wget \
    gnupg2 \
    ca-certificates \
    git \
    curl \
    zip \
    unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libicu-dev \
    supervisor \
    # Chrome deps
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
    && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y --no-install-recommends nodejs \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# 2. Install PHP extensions (including intl for Filament)
RUN docker-php-ext-install \
    pdo_mysql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    intl \
    zip

# 3. Install Google Chrome stable (non-interactive gpg key import)
RUN wget -qO - https://dl-ssl.google.com/linux/linux_signing_key.pub \
    | gpg --batch --yes --dearmor \
    > /usr/share/keyrings/google-chrome-archive-keyring.gpg \
    && echo "deb [arch=amd64 signed-by=/usr/share/keyrings/google-chrome-archive-keyring.gpg] \
    http://dl.google.com/linux/chrome/deb/ stable main" \
    > /etc/apt/sources.list.d/google-chrome.list \
    && apt-get update \
    && apt-get install -y --no-install-recommends \
    google-chrome-stable \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# 4. Configure Puppeteer environment variables
ENV PUPPETEER_SKIP_CHROMIUM_DOWNLOAD=true \
    PUPPETEER_EXECUTABLE_PATH=/usr/bin/google-chrome-stable

# 5. Enable Apache mod_rewrite and set working directory
RUN a2enmod rewrite
WORKDIR /var/www/html

# 6. Copy and install Composer dependencies (leverage cache)
COPY composer.json composer.lock ./
RUN curl -sS https://getcomposer.org/installer \
    | php -- --install-dir=/usr/local/bin --filename=composer \
    && composer install --no-dev --optimize-autoloader --no-interaction \
    && rm -rf /root/.composer/cache

# 7. Copy and install NPM dependencies & build assets
COPY package.json package-lock.json ./
RUN npm install \
    && npm run build \
    && npm cache clean --force

# 8. Copy the rest of your application
COPY . .

# 9. Set permissions on storage & cache
RUN chown -R www-data:www-data \
    /var/www/html/storage \
    /var/www/html/bootstrap/cache

# 10. Copy configuration files for Apache vhost and Supervisor
COPY .docker/vhost.conf /etc/apache2/sites-available/000-default.conf
COPY .docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# 11. Expose port 80 & start Supervisor (which will run Apache + worker)
EXPOSE 80
CMD ["/usr/bin/supervisord", "--nodaemon", "--configuration", "/etc/supervisor/conf.d/supervisord.conf"]
