# Imagem oficial do php com apache
FROM php:8.3-apache

# Instala durante a construção a imagem extensões PHP para usar o banco de dados
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Copia o arquivo de configuração do Apache para dentro do container, subtituindo o padrão
# Com isso o Apache sabe onde o site está dentro do container
# COPY ./docker/apache/vhost.conf /etc/apache2/sites-available/000-default.conf

# Ativa o módulo mod_rewrite do Apache, responsável por reescrever URLs
# .htacces não funciona sem essa configuração
RUN a2enmod rewrite

# Define o diretório de trabalho padrão do container
WORKDIR /var/www/html

# Copia tudo o que está em public/ para dentro do container, em /var/www/html/
# COPY public/ /var/www/html/

# Define o usuário e grupo de permissões da pasta /var/www/html como www-data (usuário padrão do Apache)
RUN chown -R www-data:www-data /var/www/html

# Diz ao Docker que o container vai escutar na porta 80 (HTTP padrão)
EXPOSE 80
