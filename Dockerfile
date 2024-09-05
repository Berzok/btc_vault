# Utilise l'image PHP 8.2 avec FPM et Composer
FROM php:8.2-fpm

# Définit l'utilisateur root pour les installations initiales
USER root

# Mise à jour de l'environnement et installation des dépendances système
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    locales \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

# Installe Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Définition du répertoire de travail
WORKDIR /var/www/symfony

# Copie des fichiers de votre projet Symfony dans le conteneur
COPY . .

# Met à jour Composer
RUN composer self-update

# Nettoie le cache de Composer
RUN composer clear-cache

# Installation des dépendances de l'application
RUN composer install --no-dev --optimize-autoloader --prefer-dist --no-interaction --ignore-platform-reqs --verbose

# Génération du cache pour le mode de production
RUN php bin/console cache:warmup

# Configuration des permissions sur le dossier de l'application
RUN chown -R www-data:www-data /var/www/symfony

# Expose le port 9000 pour PHP-FPM
EXPOSE 9000

# Démarre PHP-FPM
CMD ["php-fpm"]
