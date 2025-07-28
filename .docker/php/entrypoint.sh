#!/bin/sh
set -e

# Set permissions for Laravel directories
chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
chmod -R 775 /var/www/storage /var/www/bootstrap/cache

if [ ! -d "/var/www/vendor" ]; then
    composer install
fi

if [ -f /var/www/artisan ]; then
    if [ ! -f /var/www/.env ] && [ -f /var/www/.env.example ]; then
        cp /var/www/.env.example /var/www/.env
    fi

    php artisan config:clear
    php artisan key:generate --force
    php artisan config:cache
    php artisan migrate:fresh --force
    php artisan db:seed --class=DatabaseSeeder --force

fi

# permissions for PHPMyAdmin
mkdir -p /sessions

chmod 777 /sessions

exec "$@"
