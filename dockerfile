FROM php:8.2-cli

# Installation des dépendances système
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    nodejs \
    npm \
    && docker-php-ext-install pdo_sqlite mbstring exif pcntl bcmath gd zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Installation de Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Définir le répertoire de travail
WORKDIR /app

# Copier les fichiers de l'application
COPY . .

# Installation des dépendances PHP
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Installation des dépendances Node.js
RUN npm ci --silent

# Build des assets
RUN npm run build

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
