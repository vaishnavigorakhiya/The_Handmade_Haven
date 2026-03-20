FROM php:8.4-cli

# Install system dependencies + Node.js
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libxml2-dev \
    libonig-dev libzip-dev default-mysql-client nodejs npm \
    && docker-php-ext-install pdo pdo_mysql mbstring xml zip gd opcache \
    && apt-get clean

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . .

# Install PHP dependencies
RUN composer install --optimize-autoloader --no-dev --no-interaction

# Install JS dependencies and build assets
RUN npm install && npm run build

# Set permissions
RUN chmod -R 777 storage bootstrap/cache

EXPOSE 8080

CMD sh -c "\
    php artisan key:generate --force && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache && \
    php artisan migrate --force && \
    php artisan db:seed --class=AdminSeeder --force && \
    php artisan db:seed --class=ProductSeeder --force && \
    php artisan storage:link && \
    php -S 0.0.0.0:${PORT:-8080} -t public"