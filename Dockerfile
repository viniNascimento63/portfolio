FROM php:8.1-apache

# Instalar extensões necessárias para o PHP
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Habilitar o mod_rewrite do Apache
RUN a2enmod rewrite

# Diretório de trabalho
WORKDIR /var/www/html

# Copia arquivos do projeto para o contêiner
COPY src/ /var/www/html/

# Define permissões adequadas
RUN chown -R www-data:www-data /var/www/html

# Expõe porta 80
EXPOSE 80