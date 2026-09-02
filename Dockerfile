FROM php:7.4-apache

# Habilita o mod_rewrite do Apache
RUN a2enmod rewrite

# Instala as dependências do sistema e extensões PHP para o PostgreSQL/CakePHP
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libpq-dev \
    unzip \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl pdo pdo_mysql pdo_pgsql pgsql

# Define o diretório de trabalho padrão
WORKDIR /var/www/html

# Formato recomendado sem warning: chave="valor"
ENV APACHE_DOCUMENT_ROOT="/var/www/html/app/webroot"

# Configura o Apache para apontar para a webroot do CakePHP
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/conf-available/*.conf

# Garante a permissão para leitura de .htaccess no webroot
RUN echo '<Directory /var/www/html/app/webroot>\n\
    Options Indexes FollowSymLinks\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>' >> /etc/apache2/apache2.conf