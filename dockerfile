FROM php:7.4-apache

# 1. Ajusta os repositórios legados do Debian Buster e instala dependências completas
RUN echo "deb http://archive.debian.org/debian/ buster main" > /etc/apt/sources.list \
    && echo "deb http://archive.debian.org/debian-security buster/updates main" >> /etc/apt/sources.list \
    && apt-get -o Acquire::Check-Valid-Until=false -o Acquire::AllowInsecureRepositories=true update \
    && apt-get install -y --no-install-recommends \
        libpq-dev \
        libpng-dev \
        libjpeg-dev \
        libfreetype6-dev \
        libxml2-dev \
        libzip-dev \
        zip \
        git \
        unzip \
        curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_pgsql gd zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# 2. Instala o Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# 3. Configurações do PHP e Apache
RUN a2enmod rewrite
RUN echo "date.timezone = 'America/Recife'" > /usr/local/etc/php/conf.d/timezone.ini

# 4. Redireciona o DocumentRoot para a pasta webroot do CakePHP
ENV APACHE_DOCUMENT_ROOT=/var/www/html/app/webroot
RUN sed -ri -e "s!/var/www/html!${APACHE_DOCUMENT_ROOT}!g" /etc/apache2/sites-available/*.conf
RUN printf '%s\n' \
    '<Directory /var/www/html/app/webroot>' \
    '    Options Indexes FollowSymLinks' \
    '    AllowOverride All' \
    '    Require all granted' \
    '</Directory>' >> /etc/apache2/apache2.conf

# 5. Define diretório de trabalho e copia os arquivos da aplicação
WORKDIR /var/www/html
COPY . /var/www/html

# 6. Cria pastas temporárias do CakePHP e pasta de uploads
RUN mkdir -p app/tmp/cache/persistent \
             app/tmp/cache/models \
             app/tmp/cache/views \
             app/tmp/logs \
             app/webroot/files

# 7. Executa o Composer com suporte a ilimitada memória e ignorando exigências rígidas da plataforma
ENV COMPOSER_ALLOW_SUPERUSER=1
ENV COMPOSER_MEMORY_LIMIT=-1
RUN if [ -f "composer.json" ]; then composer install --no-dev --optimize-autoloader --ignore-platform-reqs --no-interaction; fi

# 8. Ajusta permissões
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 777 /var/www/html/app/tmp \
    && chmod -R 777 /var/www/html/app/webroot/files

EXPOSE 80