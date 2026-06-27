FROM php:8.2-cli
# cache bust 1

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
    git unzip curl libsqlite3-dev sqlite3 libpq-dev nodejs npm \
    && docker-php-ext-install pdo pdo_sqlite pdo_pgsql

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY . .

RUN composer install --no-dev --optimize-autoloader
RUN npm install && npm run build

RUN chmod +x start.sh

EXPOSE 10000

CMD ["./start.sh"]