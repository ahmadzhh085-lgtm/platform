FROM heroku/heroku:24-build

USER root

# Install PHP and dependencies
RUN mkdir -p /var/lib/apt/lists/partial && chmod -R 755 /var/lib/apt/lists && \
    apt-get update && apt-get install -y \
    php \
    php-cli \
    php-fpm \
    php-mysql \
    php-sqlite3 \
    php-mbstring \
    php-xml \
    php-curl \
    php-gd \
    php-zip \
    php-bcmath \
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
