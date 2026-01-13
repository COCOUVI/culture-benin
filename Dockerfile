FROM php:8.2-cli

# Dépendances système
RUN apt-get update && apt-get install -y \
    git curl unzip libzip-dev libpng-dev ca-certificates \
    && docker-php-ext-install pdo pdo_mysql zip gd \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copier le projet
COPY . .

# Suppression du touch .env pour laisser Render injecter les variables
# Installer les dépendances sans scripts (qui pourraient échouer sans DB)
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts

# Permissions
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

EXPOSE 10000

# Utilisation d'un script de démarrage plus souple
CMD php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache && \
    php artisan migrate --force && \
    php artisan serve --host=0.0.0.0 --port=10000