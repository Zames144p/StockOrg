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

# Define o diretório da aplicação e copia o projeto para a imagem
WORKDIR /var/www/html
COPY . /var/www/html/

# Altera o DocumentRoot do Apache para a pasta webroot do CakePHP
ENV APACHE_DOCUMENT_ROOT=/var/www/html/app/webroot
RUN sed -ri -e "s!/var/www/html!${APACHE_DOCUMENT_ROOT}!g" /etc/apache2/sites-available/*.conf

RUN printf '%s\n' \
    '<Directory /var/www/html/app/webroot>' \
    '    Options Indexes FollowSymLinks' \
    '    AllowOverride All' \
    '    Require all granted' \
    '</Directory>' >> /etc/apache2/apache2.conf


# Libera a escrita nos diretórios usados pelo CakePHP
RUN mkdir -p app/tmp/cache/persistent app/tmp/cache/models app/tmp/cache/views app/tmp/logs && \
    chmod -R 777 app/tmp