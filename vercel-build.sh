#!/bin/bash

# Install PHP dependencies
composer install --no-dev --optimize-autoloader --no-interaction

# Generate application key
php artisan key:generate

# Clear configuration cache
php artisan config:cache

# Clear route cache
php artisan route:cache

# Clear view cache
php artisan view:cache

# Install Node.js dependencies and build assets
npm install
npm run build

# Create storage directories if they don't exist
mkdir -p storage/framework/{sessions,views,cache}
