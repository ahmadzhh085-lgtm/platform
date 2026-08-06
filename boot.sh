#!/bin/bash

# تأكد من وجود مجلد قاعدة البيانات
mkdir -p /app/database

# أنشئ ملف قاعدة البيانات إن لم يكن موجوداً
if [ ! -f /app/database/database.sqlite ]; then
  touch /app/database/database.sqlite
fi

# قم بتشغيل migrations
php artisan migrate --force --no-interaction

# ابدأ التطبيق باستخدام Apache
exec vendor/bin/heroku-php-apache2 public/
