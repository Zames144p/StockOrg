FROM php:7.4-apache
    
# Habilita mod_rewrite
RUN a2enmod rewrite

# CORREÇÃO PARA O APT-GET (Aponta para os repositórios históricos do Debian)
RUN sed -i 's/deb.debian.org/archive.debian.org/g' /etc/apt/sources.list && \
    sed -i 's/security.debian.org/archive.debian.org/g' /etc/apt/sources.list && \
    sed -i '/stretch-updates/d' /etc/apt/sources.list && \
    sed -i '/buster-updates/d' /etc/apt/sources.list

# Instala dependências do PostgreSQL
RUN apt-get update && apt-get install -y \
        libpq-dev \
        git \
        unzip \
        curl \
    && docker-php-ext-install pdo pdo_pgsql \
    && apt-get clean  

# Instalar Composer globalmente
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Configurar timezone do PHP
RUN echo "date.timezone = 'America/Fortaleza'" > /usr/local/etc/php/conf.d/timezone.ini

# Define diretório da aplicação
WORKDIR /var/www/html
COPY . /var/www/html/

# Ajusta DocumentRoot para CakePHP
ENV APACHE_DOCUMENT_ROOT=/var/www/html/app/webroot
RUN sed -ri -e "s!/var/www/html!${APACHE_DOCUMENT_ROOT}!g" /etc/apache2/sites-available/*.conf

RUN printf '%s\n' \
    '<Directory /var/www/html/app/webroot>' \
    '    Options Indexes FollowSymLinks' \
    '    AllowOverride All' \
    '    Require all granted' \
    '</Directory>' >> /etc/apache2/apache2.conf

# Libera escrita nos diretórios usados pelo CakePHP
RUN mkdir -p app/tmp/cache/persistent app/tmp/cache/models app/tmp/cache/views app/tmp/logs && \
    chmod -R 777 app/tmp
