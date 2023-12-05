FROM php:8.1-fpm

# RUN apt-get update && \
#     apt-get install -y --no-install-recommends libssl-dev zlib1g-dev curl git unzip libxml2-dev libpq-dev libzip-dev pdo_mysql php-mysql && \
#     pecl install apcu && \
#     docker-php-ext-enable apcu pdo_mysql sodium && \
#     apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# RUN apt-get update && apt-get install php8.1 php8.1-mbstring php8.1-gettext php8.1-zip php8.1-fpm php8.1-curl php8.1-mysql php8.1-gd php8.1-cgi php8.1-soap php8.1-sqlite3 php8.1-xml php8.1-redis php8.1-bcmath php8.1-imagick php8.1-intl

RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl

RUN pecl install apcu

RUN docker-php-ext-install mysqli pdo pdo_mysql

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

#install depedencies
# RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl
# RUN docker-php-ext-configure gd --with-gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ --with-png-dir=/usr/include/
# RUN docker-php-ext-install gd

RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - &&\
    apt-get install -y nodejs

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /app
COPY . /app

RUN composer update

RUN npm install

RUN npm run build

EXPOSE 8080
CMD php artisan migrate && php artisan serve --host=0.0.0.0 --port=8080
