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

# Set permissions
RUN chmod -R 775 storage bootstrap/cache

# Expose port
EXPOSE 8080

# Start command
CMD php artisan config:clear \
    && php artisan migrate --force \
    && php artisan db:seed --class=AdminSeeder --force \
    && php artisan db:seed --class=ProductSeeder --force \
    && php artisan storage:link \
    && php artisan serve --host=0.0.0.0 --port=${PORT:-8080}
