FROM php:8.2-apache

# Instalar dependencias del sistema para pdo_pgsql
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    unzip \
    && docker-php-ext-install pdo pdo_pgsql \
    && rm -rf /var/lib/apt/lists/*

# Habilitar mod_rewrite para el enrutador
RUN a2enmod rewrite

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copiar archivos de dependencias primero para caché de Docker
COPY composer.json composer.lock* ./
RUN composer install --no-dev --optimize-autoloader

# Copiar el resto de la aplicación
COPY . .

# Configurar Apache para usar public/ como DocumentRoot
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|' /etc/apache2/sites-available/000-default.conf \
    && sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s|/var/www/html|/var/www/html/public|' /etc/apache2/apache2.conf

# Permisos
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

EXPOSE 80

CMD ["apache2-foreground"]
