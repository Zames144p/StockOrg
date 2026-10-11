FROM php:7.4-fpm-alpine

# 1. Instala dependências do sistema e extensões para PostgreSQL + GD + Zip
RUN apk add --no-cache \
    apache2 \
    apache2-utils \
    postgresql-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_pgsql gd zip

# 2. Configura o Apache no Alpine
RUN mkdir -p /run/apache2
RUN sed -i 's/#LoadModule rewrite_module/LoadModule rewrite_module/' /etc/apache2/httpd.conf
RUN sed -i 's/#LoadModule proxy_module/LoadModule proxy_module/' /etc/apache2/httpd.conf
RUN sed -i 's/#LoadModule proxy_fcgi_module/LoadModule proxy_fcgi_module/' /etc/apache2/httpd.conf

# 3. Configura o DocumentRoot para o webroot do CakePHP
ENV APACHE_DOCUMENT_ROOT=/var/www/html/app/webroot
RUN sed -ri -e "s!/var/www/localhost/htdocs!${APACHE_DOCUMENT_ROOT}!g" /etc/apache2/httpd.conf
RUN sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/httpd.conf

# 4. Copia os arquivos do projeto
WORKDIR /var/www/html
COPY . /var/www/html

# 5. Estrutura de pastas temporárias do CakePHP e permissões
RUN mkdir -p app/tmp/cache/persistent \
             app/tmp/cache/models \
             app/tmp/cache/views \
             app/tmp/logs \
             app/webroot/files

RUN chown -R apache:apache /var/www/html \
    && chmod -R 777 /var/www/html/app/tmp \
    && chmod -R 777 /var/www/html/app/webroot/files

EXPOSE 80

CMD ["sh", "-c", "php-fpm -D && httpd -D FOREGROUND"]