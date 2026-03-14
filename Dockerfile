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
RUN chmod -R 777 storage bootstrap/cache

# Expose port
EXPOSE 8080

# Start script
CMD sh -c "php artisan config:clear && \
    php artisan migrate --force && \
    php artisan db:seed --class=AdminSeeder --force && \
    php artisan db:seed --class=ProductSeeder --force && \
    php artisan storage:link && \
    php -S 0.0.0.0:8080 -t public"