FROM php:8.3-cli-alpine

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Extensões PHP necessárias (PostgreSQL)
RUN apk add --no-cache postgresql-dev \
    && docker-php-ext-install pdo_pgsql

WORKDIR /var/www/html

# Aplicação
COPY . .

# Dependências de produção otimizadas (ativa o bootstrap/cache/packages.php)
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

# Pastas com escrita usadas em runtime
RUN chmod -R 775 storage bootstrap/cache

EXPOSE 8080

# Migração/seed/caches no start (env de runtime disponível aqui, não no build)
CMD php artisan migrate --force \
    && php artisan db:seed --force \
    && php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache \
    && exec php artisan serve --host=0.0.0.0 --port=${PORT:-8080}