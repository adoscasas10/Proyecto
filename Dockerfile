# Usamos la versión oficial de PHP con Apache
FROM php:8.2-apache

# Instalamos las extensiones necesarias para conectar con la BD (PDO)
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Activamos mod_rewrite por si usas URLs amigables en el futuro
RUN a2enmod rewrite