FROM php:8.2-fpm

# Dépendances système
RUN apt-get update && apt-get install -y \
    git curl unzip libonig-dev libzip-dev zip \
    && docker-php-ext-install pdo pdo_mysql mbstring zip

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copier le projet
COPY . .

# Installer dépendances
RUN composer install --no-dev --optimize-autoloader

# Permissions Laravel
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Optimisation production
RUN php artisan key:generate --force || true \
    && php artisan config:clear \
    && php artisan route:clear \
    && php artisan view:clear \
    && php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache

# Port Render
EXPOSE 10000

# Lancer Laravel (serveur PHP natif)
CMD ["php", "-S", "0.0.0.0:10000", "-t", "public"]
