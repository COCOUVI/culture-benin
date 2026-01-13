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

# Créer un fichier .env vide (Laravel en a besoin)
RUN touch .env

# Installer dépendances
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Permissions
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

EXPOSE 10000

# Démarrage : les variables d'environnement Render seront utilisées automatiquement
CMD php artisan config:clear && \
    php artisan cache:clear && \
    php artisan key:generate --force && \
    php artisan migrate --force && \
    php artisan serve --host=0.0.0.0 --port=10000