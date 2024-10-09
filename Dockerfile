# Use official PHP image
FROM php:8.0-apache

# Copy project files to the working directory
COPY . /var/www/html/

# Install PHP extensions if needed (optional)
RUN docker-php-ext-install mysqli
