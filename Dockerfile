FROM node:20-bookworm-slim AS frontend
WORKDIR /app
COPY package*.json ./
RUN npm ci
COPY . .
RUN npm run build

FROM php:8.2-fpm-bookworm

RUN apt-get update && apt-get install -y nginx git unzip libcurl4-openssl-dev libicu-dev libxml2-dev libzip-dev libpq-dev \
    && docker-php-ext-install -j$(nproc) bcmath curl intl opcache pcntl pdo_mysql pdo_pgsql simplexml zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .
COPY --from=frontend /app/public/build /app/public/build

RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist > /tmp/composer-install.log 2>&1 || (tail -n 100 /tmp/composer-install.log && exit 1) \
    && chown -R www-data:www-data storage bootstrap/cache \
    && rm -f /etc/nginx/sites-enabled/default

RUN printf '%s\n' \
'server {' \
'    listen __PORT__;' \
'    listen [::]:__PORT__;' \
'    root /app/public;' \
'    index index.php index.html;' \
'    charset utf-8;' \
'    client_max_body_size 64m;' \
'    access_log /dev/stdout;' \
'    error_log /dev/stderr;' \
'    location / { try_files $uri $uri/ /index.php?$query_string; }' \
'    location ~ \.php$ {' \
'        try_files $uri =404;' \
'        fastcgi_pass 127.0.0.1:9000;' \
'        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;' \
'        include fastcgi_params;' \
'    }' \
'    location ~ /\.(?!well-known).* { deny all; }' \
'}' \
> /etc/nginx/conf.d/app.conf

RUN echo "clear_env = no" >> /usr/local/etc/php-fpm.d/www.conf

EXPOSE 3000

CMD ["sh", "-c", "sed -i \"s/__PORT__/${PORT:-3000}/g\" /etc/nginx/conf.d/app.conf && (php artisan storage:link || true) && (php artisan config:cache || true) && (php artisan route:cache || true) && (php artisan view:cache || true) && php-fpm -D && exec nginx -g 'daemon off;'"]
