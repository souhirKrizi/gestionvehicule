# Build stage for Node.js dependencies
FROM node:20 AS node

WORKDIR /app

# Copy package files needed for npm install
COPY package*.json ./
COPY webpack.mix.js ./

# Install dependencies
RUN npm ci

# Copy the rest of the application
COPY . .

# Build assets
RUN npm run production

# Production stage
FROM php:8.2-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY --from=node /app /var/www/html

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction \
    && php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache

# Set permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Configure Apache
COPY docker/000-default.conf /etc/apache2/sites-available/000-default.conf
RUN a2enmod rewrite

# Expose port 80
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]
COPY package*.json ./
COPY webpack.mix.js ./

# Install dependencies and build assets
RUN npm ci && npm run production

# Final stage
FROM php:8.2-fpm

# Installation des dépendances système
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    gnupg \
    ca-certificates \
    wget \
    && docker-php-ext-install pdo pdo_pgsql bcmath gd zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Installation de Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Définir le répertoire de travail
WORKDIR /var/www/html

# Copier les fichiers de l'application
COPY . .

# Copier les assets compilés depuis l'étape node
COPY --from=node /app/public/build/ ./public/build/

# Installer les dépendances PHP
RUN composer install --no-dev --optimize-autoloader --no-interaction \
    && php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache

# Définir les permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Créer le lien symbolique de stockage
RUN php artisan storage:link

# Exposer le port 8000
EXPOSE 8000

# Commande de démarrage
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
# Vérification de l'installation de Vite
RUN echo "Node version: " && node --version
RUN echo "npm version: " && npm --version
RUN echo "Vite version: " && npx vite --version || echo "Vite not yet installed"

# Build des assets avec Vite
RUN npx vite build

# Copier le reste des fichiers de l'application
COPY . .

# Créer les répertoires nécessaires
RUN mkdir -p database storage/logs storage/framework/{cache,sessions,views} bootstrap/cache

# Créer la base de données SQLite
RUN touch database/database.sqlite

# Définir les permissions
RUN chmod -R 775 storage bootstrap/cache database

# Copier le fichier d'environnement pour Hugging Face
COPY .env.huggingface .env

# Générer la clé d'application
RUN php artisan key:generate --force

# Configurer le fichier de démarrage
COPY start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh

# Commande par défaut
CMD ["/usr/local/bin/start.sh"]

# Exécuter les migrations et seeders
RUN php artisan migrate --force && \
    php artisan db:seed --force

# Optimiser pour la production
RUN php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache

# Copier et rendre exécutable le script de démarrage
COPY start-huggingface.sh /app/start-huggingface.sh
RUN chmod +x /app/start-huggingface.sh

# Exposer le port 7860 (requis par Hugging Face)
EXPOSE 7860

# Commande de démarrage
CMD ["/app/start-huggingface.sh"]
