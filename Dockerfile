FROM php:8.2-fpm

# Встановлення необхідних пакетів
RUN apt-get update && apt-get install -y \
    zip unzip git curl libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Встановлення Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Створення робочої директорії
WORKDIR /var/www

# Копіюємо проект в контейнер
COPY . .

# Встановлюємо залежності Laravel
RUN composer install --no-dev --optimize-autoloader

# Надаємо права на зберігання кешу
RUN chmod -R 777 storage bootstrap/cache

# Відкриваємо порт
EXPOSE 9000

# Запускаємо PHP-FPM
CMD ["php-fpm"]
