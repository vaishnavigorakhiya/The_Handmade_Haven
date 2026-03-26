FROM php:8.4-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libxml2-dev \
    libonig-dev libzip-dev default-mysql-client nodejs npm \
    && docker-php-ext-install pdo pdo_mysql mbstring xml zip gd opcache \
    && apt-get clean

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /app

# Copy project files
COPY . .

# APP_KEY is intentionally left blank here — key:generate fills it in at runtime.
RUN cp .env.example .env

# Install PHP dependencies
RUN composer install --optimize-autoloader --no-dev --no-interaction


# that load CSS/JS via Vite manifest will throw a 500 error.
RUN npm ci && npm run build && rm -rf node_modules

# Set permissions
RUN chmod -R 777 storage bootstrap/cache

# Expose port
EXPOSE 8080

CMD sh -c " \
    php artisan key:generate --force && \
    php artisan config:clear && \
    php artisan migrate --force && \
    php artisan db:seed --class=AdminSeeder --force && \
    php artisan db:seed --class=ProductSeeder --force && \
    php artisan storage:link && \
    php -S 0.0.0.0:${PORT:-8080} -t public \
"
