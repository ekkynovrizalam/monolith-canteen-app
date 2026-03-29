#!/bin/bash
set -e

# Install dependencies if vendor doesn't exist (e.g. when using volume mount)
if [ ! -d "vendor" ]; then
    composer install --no-interaction --optimize-autoloader
fi

# Generate app key if not set
if [ -z "$APP_KEY" ]; then
    php artisan key:generate --force
fi

# Run migrations
php artisan migrate --force

# Clear and cache config
php artisan config:cache

exec "$@"
