#!/bin/bash

# تأكد من وجود مجلد قاعدة البيانات بصلاحيات 777
mkdir -p /app/database
chmod -R 777 /app/database

# أنشئ ملف قاعدة البيانات إن لم يكن موجوداً
if [ ! -f /app/database/database.sqlite ]; then
  touch /app/database/database.sqlite
  chmod 666 /app/database/database.sqlite
fi

# تأكد من وجود مجلد storage بصلاحيات صحيحة
mkdir -p /app/storage/app /app/storage/logs /app/storage/framework/sessions /app/storage/framework/cache
chmod -R 777 /app/storage

# قم بتشغيل migrations
echo "Running migrations..."
php artisan migrate --force --no-interaction 2>&1 || echo "Migrations warning (may be normal)"

echo "Clearing caches and caching..."
php artisan config:cache 2>&1 || true
php artisan route:cache 2>&1 || true

echo "Build complete. Starting server..."

# ابدأ التطبيق باستخدام Apache
exec vendor/bin/heroku-php-apache2 public/
