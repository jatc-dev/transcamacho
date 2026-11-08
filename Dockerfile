FROM php:8.2-apache

# Instalar extensiones PHP necesarias para PostgreSQL
RUN docker-php-ext-install pdo pdo_pgsql

WORKDIR /var/www/html

# Habilitar mod_rewrite para .htaccess
RUN a2enmod rewrite

# Copiar la aplicación FUEC al document root
COPY fuec/ /var/www/html/

# Permisos
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

EXPOSE 80

CMD ["apache2-foreground"]
