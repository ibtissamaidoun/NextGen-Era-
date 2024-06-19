# Use an official PHP runtime as a base image
FROM php:8.2-fpm

# Set the working directory in the container
WORKDIR /var/www/html

# Install dependencies
RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip \
    libpng-dev \
    libjpeg-dev \
    libfreetype-dev \
    libzip-dev \
    libpq-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo pdo_pgsql zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Copy the Laravel application files from the laravel-app directory into the container
COPY . /var/www/html

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install application dependencies
#RUN composer install --no-interaction --no-scripts --no-suggest --prefer-dist --optimize-autoloader
RUN composer update 

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage

# Expose port (optional)
EXPOSE 8000

# Entrypoint
# <<<<<<< HEAD
CMD ["php", "artisan", "serve", "--host=10.0.2.15", "--port=8000"]
#=======
# CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
# >>>>>>> 084354b7f14022652e7691ab43da68b9f3637a52
