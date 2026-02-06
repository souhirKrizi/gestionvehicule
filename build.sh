#!/bin/bash
set -e

echo "Building Laravel app for Render..."

# Install Composer if not available
if ! command -v composer &> /dev/null; then
    echo "Installing Composer..."
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
    php composer-setup.php --install-dir=/usr/local/bin --filename=composer
    rm composer-setup.php
fi

# Install PHP dependencies
echo "Installing PHP dependencies..."
composer install --no-dev --optimize-autoloader --no-interaction

# Install Node dependencies
echo "Installing Node dependencies..."
npm install

# Build assets
echo "Building assets..."
npm run build

# Setup Laravel
echo "Setting up Laravel..."
cp .env.render .env
mkdir -p database storage/logs storage/framework/{cache,sessions,views} bootstrap/cache
touch database/database.sqlite
chmod -R 775 storage bootstrap/cache database

# Laravel commands
php artisan key:generate --force
php artisan migrate --force
php artisan db:seed --force
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Build completed successfully!"