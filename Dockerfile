FROM php:7.4-apache

# Habilita o mod_rewrite do Apache
RUN a2enmod rewrite

# Instala as dependências de compilação do PostgreSQL e do sistema
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libpq-dev \
    unzip \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl pdo pdo_mysql pdo_pgsql pgsql