# Use the base PHP Apache image
FROM php:8.1-apache

# Update and install required tools
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    unzip \
    zip \
    && docker-php-ext-install \
    mysqli \
    pdo \
    pdo_mysql \
    && docker-php-ext-enable \
    mysqli \
    pdo_mysql

# Enable Apache rewrite module (optional for Laravel, etc.)
RUN a2enmod rewrite

# Set permissions (optional, if needed)
RUN chown -R www-data:www-data /var/www/html

# Expose the default Apache port
EXPOSE 80
