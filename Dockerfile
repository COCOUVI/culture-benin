FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    git curl unzip libzip-dev libpng-dev \
    ca-certificates \
    && docker-php-ext-install pdo pdo_mysql zip gd \
    && apt-get clean

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
COPY . .

# Ne pas créer .env ici, utiliser les variables d'environnement Render
RUN composer install --no-dev --optimize-autoloader

# Ne PAS faire de cache config en build time
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

EXPOSE 10000

# Script de démarrage qui génère la clé et teste la BDD
CMD php artisan key:generate --force && \
    php artisan config:clear && \
    php artisan migrate --force && \
    php artisan serve --host=0.0.0.0 --port=10000