FROM heroku/heroku:24-build

USER root

# Install PHP and dependencies
RUN apt-get update && apt-get install -y \
    php8.2 \
    php8.2-cli \
    php8.2-fpm \
    php8.2-mysql \
    php8.2-sqlite3 \
    php8.2-pdo \
    php8.2-mbstring \
    php8.2-xml \
    php8.2-curl \
    php8.2-gd \
    php8.2-zip \
    php8.2-bcmath \
    composer \
    npm \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /app

# Copy project files
COPY . .

# Set permissions
RUN chmod +x boot.sh
RUN mkdir -p /app/database /app/storage
RUN chmod -R 777 /app/database /app/storage

# Install dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction
RUN npm install && npm run build

# Cache configuration
RUN php artisan config:cache

EXPOSE 8000

CMD ["sh", "boot.sh"]
