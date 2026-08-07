#!/bin/bash

# حدد مسار قاعدة البيانات من متغير البيئة أو الافتراضي
DB_PATH="${DB_DATABASE:-/app/database/database.sqlite}"
DB_DIR=$(dirname "$DB_PATH")

echo "Database path: $DB_PATH"

# تأكد من وجود مجلد قاعدة البيانات بصلاحيات 777
mkdir -p "$DB_DIR"
chmod -R 777 "$DB_DIR"

# أنشئ ملف قاعدة البيانات إن لم يكن موجوداً
if [ ! -f "$DB_PATH" ]; then
  echo "Creating database file: $DB_PATH"
  touch "$DB_PATH"
  chmod 666 "$DB_PATH"
fi

# تأكد من وجود مجلد storage بصلاحيات صحيحة
mkdir -p /app/storage/app /app/storage/logs /app/storage/framework/sessions /app/storage/framework/cache
chmod -R 777 /app/storage

echo "SESSION_DRIVER: ${SESSION_DRIVER:-file}"
echo "CACHE_STORE: ${CACHE_STORE:-file}"
echo "DB_CONNECTION: ${DB_CONNECTION:-sqlite}"

# قم بتشغيل migrations
echo "Running migrations..."
php artisan migrate --force --no-interaction 2>&1 || echo "Migrations completed or skipped"

echo "Clearing old caches..."
php artisan config:clear 2>&1 || true
php artisan route:clear 2>&1 || true
php artisan view:clear 2>&1 || true
php artisan cache:clear 2>&1 || true

echo "Caching configurations..."
php artisan config:cache 2>&1 || true

echo "Build complete. Starting server..."

HOST="${HOST:-0.0.0.0}"
PORT="${PORT:-8000}"

echo "Starting Laravel development server on $HOST:$PORT"
exec php artisan serve --host="$HOST" --port="$PORT"
