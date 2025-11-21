FROM php:8.2-apache

# --- 🚨 CORRECCIÓN CLAVE: COPIAR EL CÓDIGO 🚨 ---
# Copia todo el contenido de tu carpeta local (donde está el Dockerfile) 
# al directorio raíz de Apache en el contenedor (/var/www/html).
COPY . /var/www/html

# Instalamos las extensiones necesarias para conectar con la BD (PDO)
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Activamos mod_rewrite por si usas URLs amigables en el futuro
RUN a2enmod rewrite
