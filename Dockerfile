FROM php:8.1-apache

# Instala extensiones necesarias
RUN apt-get update && apt-get install -y libpq-dev && docker-php-ext-install pdo pdo_pgsql

# Habilitar mod_rewrite (si usas .htaccess)
RUN a2enmod rewrite

# Copiar los archivos al contenedor
COPY . /var/www/html/

# Ajustar permisos
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
    