#!/usr/bin/env bash
set -e

php artisan config:clear || true
php artisan storage:link || true
php artisan migrate --force || true

php artisan serve --host=0.0.0.0 --port=10000
