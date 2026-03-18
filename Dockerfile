FROM php:8.4-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libxml2-dev \
    libonig-dev libzip-dev default-mysql-client \
    && docker-php-ext-install pdo pdo_mysql mbstring xml zip gd opcache \
    && apt-get clean

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /app

# Copy project files
COPY . .

# Install PHP dependencies
RUN composer install --optimize-autoloader --no-dev --no-interaction

# Ensure the public storage directory exists so storage:link never fails
# even when storage/app/public/ is empty (gitignored uploads folder).
RUN mkdir -p storage/app/public/products \
    && chmod -R 777 storage bootstrap/cache

# Expose port
EXPOSE 8080

CMD sh -c "php artisan config:clear && \
    php artisan migrate --force 2>&1 && \
    php artisan db:seed --class=AdminSeeder --force 2>&1 && \
    php artisan db:seed --class=ProductSeeder --force 2>&1 && \
    php artisan storage:link 2>&1 && \
    php -S 0.0.0.0:${PORT:-8080} -t public"