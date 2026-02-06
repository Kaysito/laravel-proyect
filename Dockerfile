# Usamos una imagen oficial de PHP con Apache
FROM php:8.2-apache

# 1. Instalamos dependencias del sistema y extensiones de PHP necesarias
RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip \
    libzip-dev \
    libpng-dev \
    && docker-php-ext-install pdo_mysql zip gd

# 2. Activamos el módulo "rewrite" de Apache (vital para las rutas de Laravel)
RUN a2enmod rewrite

# 3. Configuramos la carpeta pública de Apache para que apunte a /public de Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# 4. Instalamos Composer (el gestor de paquetes)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 5. Copiamos todos tus archivos al contenedor
WORKDIR /var/www/html
COPY . .

# 6. Instalamos las librerías de Laravel
RUN composer install --no-dev --optimize-autoloader

# 7. Damos permisos a las carpetas de almacenamiento
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# 8. COMANDO DE ARRANQUE: Limpia caché y LUEGO inicia Apache
CMD sh -c "php artisan optimize:clear && apache2-foreground"