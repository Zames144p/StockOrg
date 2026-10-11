FROM php:7.4-apache

# Ajusta os repositórios legados do Debian Buster e instala dependências
RUN echo "deb http://archive.debian.org/debian/ buster main" > /etc/apt/sources.list \
    && echo "deb http://archive.debian.org/debian-security buster/updates main" >> /etc/apt/sources.list \
    && apt-get -o Acquire::Check-Valid-Until=false -o Acquire::AllowInsecureRepositories=true update \
    && apt-get install -y --no-install-recommends \
        libpq-dev \
        git \
        unzip \
        curl \
    && docker-php-ext-install pdo pdo_pgsql \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Instala o Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Configurações do PHP e Apache
RUN a2enmod rewrite
RUN echo "date.timezone = 'America/Recife'" > /usr/local/etc/php/conf.d/timezone.ini

# Redireciona o DocumentRoot para a pasta webroot do CakePHP
ENV APACHE_DOCUMENT_ROOT=/var/www/html/app/webroot
RUN sed -ri -e "s!/var/www/html!${APACHE_DOCUMENT_ROOT}!g" /etc/apache2/sites-available/*.conf
RUN printf '%s\n' \
    '<Directory /var/www/html/app/webroot>' \
    '    Options Indexes FollowSymLinks' \
    '    AllowOverride All' \
    '    Require all granted' \
    '</Directory>' >> /etc/apache2/apache2.conf

# Define diretório de trabalho e copia os arquivos da aplicação
WORKDIR /var/www/html
COPY . /var/www/html

# Cria pastas temporárias do CakePHP e pasta de uploads
RUN mkdir -p app/tmp/cache/persistent \
             app/tmp/cache/models \
             app/tmp/cache/views \
             app/tmp/logs \
             app/webroot/files

# Executa a instalação de dependências do Composer (se houver composer.json)
RUN if [ -f "composer.json" ]; then composer install --no-dev --optimize-autoloader; fi

# Ajusta as permissões para o usuário 'www-data' (dono do processo do Apache)
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 777 /var/www/html/app/tmp \
    && chmod -R 777 /var/www/html/app/webroot/files

EXPOSE 80