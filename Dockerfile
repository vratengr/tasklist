FROM php:8.2-apache
RUN apt update && apt upgrade -y

# optional packages for debugging in container
RUN apt install nano git

# install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

#install laravel required extensions (for when running composer/artisan)
RUN apt install -y zip
RUN apt update && apt upgrade -y
RUN apt install -y nodejs && apt install -y npm
RUN docker-php-ext-install pdo_mysql && docker-php-ext-enable pdo_mysql

# enable mod_rewrite since we're using .htaccess
RUN a2enmod rewrite

# restart apache since there are web server changes
RUN service apache2 restart