#!/usr/bin/env bash
set -e

mkdir -p database
touch database/database.sqlite

php artisan config:clear || true
php artisan cache:clear || true
php artisan view:clear || true
php artisan route:clear || true
php artisan storage:link || true
php artisan migrate --force || true
php artisan db:seed --force || true

php artisan serve --host=0.0.0.0 --port=${PORT:-10000}