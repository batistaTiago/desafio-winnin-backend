FROM php:7.4-fpm

RUN apt-get update && apt-get install -y \
		libfreetype6-dev \
		libjpeg62-turbo-dev \
		libpng-dev \
		cron \
		zip \
		unzip \
		zlib1g-dev \
		libzip-dev \
	&& docker-php-ext-install pcntl pdo pdo_mysql zip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html/src

COPY ./src/composer*.json ./

WORKDIR /var/www/html/

# Create the log file to be able to run tail
# RUN touch /tmp/cron.log

# Setup cron job
RUN (crontab -l ; echo "* * * * * cd /var/www/html && /usr/local/bin/php artisan schedule:run >> /tmp/cron.log") | crontab
