#!/bin/bash

set -e

DB_PATH="${DB_DATABASE:-/app/database/database.sqlite}"
DB_DIR=$(dirname "$DB_PATH")

echo "Database path: $DB_PATH"

mkdir -p "$DB_DIR"
chmod -R 777 "$DB_DIR"

if [ "${DB_CONNECTION:-sqlite}" = "sqlite" ]; then
  if [ ! -f "$DB_PATH" ]; then
    echo "Creating database file: $DB_PATH"
    touch "$DB_PATH"
    chmod 666 "$DB_PATH"
  fi
fi

mkdir -p /app/storage/app /app/storage/logs /app/storage/framework/sessions /app/storage/framework/cache
chmod -R 777 /app/storage

echo "SESSION_DRIVER: ${SESSION_DRIVER:-file}"
echo "CACHE_STORE: ${CACHE_STORE:-file}"
echo "DB_CONNECTION: ${DB_CONNECTION:-sqlite}"

echo "Running migrations..."
php artisan migrate --force --no-interaction || true

echo "Seeding admin user..."
php artisan db:seed --class=AdminUserSeeder --force || true

echo "Clearing old caches..."
php artisan config:clear || true
php artisan route:clear || true
php artisan view:clear || true
php artisan cache:clear || true

echo "Caching routes and views (config caching disabled to keep Vite manifest resolution working)..."
php artisan route:cache || true
php artisan view:cache || true

echo "Starting Laravel server..."

PORT="${PORT:-8000}"

echo "Starting Laravel server on 0.0.0.0:$PORT"
exec php artisan serve --host=0.0.0.0 --port="$PORT"

