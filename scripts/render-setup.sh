#!/bin/bash
set -e

mkdir -p /var/data
if [ ! -f /var/data/database.sqlite ]; then
  touch /var/data/database.sqlite
fi

php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan migrate --force
