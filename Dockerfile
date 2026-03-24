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
    echo '==> Generating app key...' && php artisan key:generate --force && \
    echo '==> Caching config...' && php artisan config:cache && \
    echo '==> Caching routes...' && php artisan route:cache && \
    echo '==> Caching views...' && php artisan view:cache && \
    echo '==> Running migrations...' && php artisan migrate --force && \
    echo '==> Seeding admin...' && php artisan db:seed --class=AdminSeeder --force || true && \
    echo '==> Seeding products...' && php artisan db:seed --class=ProductSeeder --force || true && \
    echo '==> Linking storage...' && php artisan storage:link || true && \
    echo '==> Starting server on port ${PORT:-8080}...' && \
    php -S 0.0.0.0:${PORT:-8080} -t public"