#!/usr/bin/env sh
set -e

echo "=== APP STARTING ==="
php artisan optimize:clear || true

echo "=== RUNNING MIGRATIONS ==="
php artisan migrate --force

echo "=== RUNNING SEEDER ==="
php artisan db:seed --force

echo "=== STARTING APACHE ==="
apache2-foreground