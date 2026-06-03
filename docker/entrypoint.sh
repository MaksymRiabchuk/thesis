#!/bin/bash

cd /var/www

git config --global --add safe.directory '*'

echo "Checking .env file..."
if [ ! -f .env ]; then
    cp .env.example .env
    echo ".env file was created from .env.example"
fi

echo "Installing composer dependencies..."
composer install --no-interaction --prefer-dist --optimize-autoloader

echo "Generating key"
php artisan key:generate --no-interaction

echo "Clearing cache and filling the database"
php artisan optimize:clear
php artisan migrate:fresh --seed --force

echo "Application launched, running server..."
php artisan serve --host=0.0.0.0 --port=8000