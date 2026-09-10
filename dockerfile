FROM php:7.4-apache

# Ajusta o repositório histórico do Debian Buster e instala dependências como ROOT
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

# Instala o Composer globalmente
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Configura o Apache e Timezone como ROOT
RUN a2enmod rewrite
RUN echo "date.timezone = 'America/Fortaleza'" > /usr/local/etc/php/conf.d/timezone.ini

# Ajusta DocumentRoot para o webroot do CakePHP
ENV APACHE_DOCUMENT_ROOT=/var/www/html/app/webroot
RUN sed -ri -e "s!/var/www/html!${APACHE_DOCUMENT_ROOT}!g" /etc/apache2/sites-available/*.conf
RUN printf '%s\n' \
    '<Directory /var/www/html/app/webroot>' \
    '    Options Indexes FollowSymLinks' \
    '    AllowOverride All' \
    '    Require all granted' \
    '</Directory>' >> /etc/apache2/apache2.conf

# Define diretório de trabalho e cria a estrutura de pastas temporárias do CakePHP
WORKDIR /var/www/html
RUN mkdir -p app/tmp/cache/persistent app/tmp/cache/models app/tmp/cache/views app/tmp/logs

# Cria o usuário "app" e ajusta as permissões de dona das pastas
RUN groupadd -g 1000 app && \
    useradd -u 1000 -g app -m -s /bin/bash app && \
    chown -R app:app /var/www/html && \
    chmod -R 777 /var/www/html/app/tmp