# Utilisation d'une image de base avec PHP 8.2 et Node.js 20
FROM php:8.2-fpm

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
    gnupg \
    ca-certificates \
    wget \
    && docker-php-ext-install pdo_sqlite mbstring exif pcntl bcmath gd zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Installation de Node.js 20.x via n (Node Version Manager)
RUN curl -L https://raw.githubusercontent.com/tj/n/master/bin/n -o n \
    && bash n lts \
    && rm n \
    && npm install -g npm@latest \
    && npm install -g n \
    && n 20.19.0 \
    && npm install -g npm@latest \
    && ln -sf /usr/local/n/versions/node/20.19.0/bin/node /usr/local/bin/node \
    && ln -sf /usr/local/n/versions/node/20.19.0/bin/npm /usr/local/bin/npm \
    && ln -sf /usr/local/n/versions/node/20.19.0/bin/npx /usr/local/bin/npx

# Vérification de l'installation
RUN echo "Node.js version: $(node --version)" \
    && echo "npm version: $(npm --version)" \
    && echo "Node.js path: $(which node)" \
    && echo "npm path: $(which npm)" \
    && echo "npx path: $(which npx)"

# Installation de Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Vérification des installations
RUN node --version \
    && npm --version \
    && php -v

# Définir le répertoire de travail
WORKDIR /app

# Copier uniquement les fichiers nécessaires pour l'installation des dépendances
COPY composer.json composer.lock package.json package-lock.json ./
COPY resources/ ./resources/
COPY vite.config.js ./

# Installation des dépendances PHP
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts

# Installation des dépendances Node.js
RUN npm ci --silent --legacy-peer-deps

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
