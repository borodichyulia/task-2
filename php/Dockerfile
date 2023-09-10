FROM php:8.1-fpm-alpine

# Update system core

RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Start PHP-FPM
CMD ["php-fpm"]