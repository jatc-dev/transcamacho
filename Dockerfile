FROM php:8.2-apache

# Instalar extensiones PHP necesarias
RUN docker-php-ext-install pdo pdo_mysql

WORKDIR /var/www/html

# Habilitar mod_rewrite para .htaccess
RUN a2enmod rewrite

# Copiar la aplicación FUEC al document root
COPY fuec/ /var/www/html/

# Copiar .htaccess si existe en la raíz (para reglas de SSL/WWW)
COPY .htaccess /var/www/html/.htaccess 2>/dev/null || true

# Permisos
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

EXPOSE 80

CMD ["apache2-foreground"]
