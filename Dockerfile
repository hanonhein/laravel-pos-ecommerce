FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nodejs \
    npm

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /app

# Copy the entire application first
COPY . .

# Copy .env.example to .env for build process
RUN cp .env.example .env

# Install PHP dependencies with no scripts to avoid artisan issues
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts

# Now run the post-autoload scripts manually
RUN composer run-script post-autoload-dump

# Generate application key
RUN php artisan key:generate --no-interaction

# Install Node dependencies and build assets
RUN npm ci && npm run build

# Set permissions
RUN chown -R www-data:www-data /app/storage /app/bootstrap/cache
RUN chmod -R 775 /app/storage /app/bootstrap/cache

# Create storage symbolic link
RUN php artisan storage:link --force

# Expose port
EXPOSE 8000

# Start the application
CMD php artisan serve --host=0.0.0.0 --port=8000
