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

# Start command — each step on its own line so we can see exactly where it crashes
CMD php artisan config:clear \
    && echo "✅ Config cleared" \
    && php artisan migrate --force \
    && echo "✅ Migrations done" \
    && php artisan db:seed --class=AdminSeeder --force \
    && echo "✅ Admin seeded" \
    && php artisan db:seed --class=ProductSeeder --force \
    && echo "✅ Products seeded" \
    && php artisan storage:link \
    && echo "✅ Storage linked" \
    && echo "✅ Starting server..." \
    && php artisan serve --host=0.0.0.0 --port=8080