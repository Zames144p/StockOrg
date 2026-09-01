FROM php:7.4-apache

# Habilita o mod_rewrite do Apache (essencial para as rotas do CakePHP)
RUN a2enmod rewrite

# Instala dependências do sistema e extensões do PHP
RUN apt-get update && apt-get install -y \
    libicu-dev \
    unzip \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl pdo pdo_mysql pdo_pgsql pgsql    
