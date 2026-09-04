FROM php:8.2-apache

# Extensiones PHP necesarias para Laravel + MySQL
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip \
    && a2enmod rewrite \
    && a2dismod mpm_event mpm_worker mpm_prefork || true \
    && a2enmod mpm_prefork

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . .

# Apache debe servir desde /public
RUN sed -i 's#/var/www/html#/var/www/html/public#g' /etc/apache2/sites-available/000-default.conf
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN composer install --no-dev --optimize-autoloader --no-interaction \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache

# Railway asigna el puerto dinámicamente
RUN echo "Listen ${PORT:-8080}" > /etc/apache2/ports.conf \
    && sed -i "s/:80>/:${PORT:-8080}>/" /etc/apache2/sites-available/000-default.conf

EXPOSE 8080

CMD ["sh", "-c", "php artisan config:cache && php artisan route:cache && php artisan migrate --force && apache2-foreground"]
