FROM php:8.2-cli

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        curl \
        git \
        libicu-dev \
        libonig-dev \
        unzip \
    && docker-php-ext-install intl mbstring \
    && rm -rf /var/lib/apt/lists/*

RUN curl -sS https://getcomposer.org/installer \
    | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /app

EXPOSE 8765

CMD ["sh", "-lc", "composer install && php bin/cake.php server -H 0.0.0.0 -p 8765"]
