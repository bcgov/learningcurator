FROM php:8.1-apache
# TODO switch to buster once https://github.com/docker-library/php/issues/865 is resolved in a clean way (either in the PHP image or in PHP itself)

RUN rm -vfr /var/lib/apt/lists/*

RUN apt-get update -y
RUN apt-get install -y git vim

RUN set -eux; \
	\
	if command -v a2enmod; then \
		a2enmod rewrite; \
	fi; \
	\
	savedAptMark="$(apt-mark showmanual)"; \
	\
	apt-get install -y \
		libfreetype6-dev \
		libjpeg-dev \
		libpng-dev \
		libpq-dev \
		libssl-dev \
		ca-certificates \
		libcurl4-openssl-dev \
		libgd-tools \
		libmcrypt-dev \
		zip \
		default-mysql-client \
		vim \
		wget \
		libicu-dev \
  		ca-certificates \
		libcurl4-openssl-dev \
		libgd-tools \
		libmcrypt-dev \
		default-mysql-client \
		vim \
		wget \
		libbz2-dev \
		libzip-dev \
		zlib1g-dev \
		libpng-dev \
		libjpeg-dev \
		libpng-dev \
		freetype* \
		libfreetype6-dev \
	; \
	\
	docker-php-ext-configure gd \
		--with-freetype=/usr \
		--with-jpeg=/usr \
	; \
	\
	docker-php-ext-install -j "$(nproc)" \
		pdo_mysql \
		zip \
		bcmath \
		bz2 \
		exif \
		ftp \
		gd \
		gettext \
		mysqli \
		opcache \
		shmop \
		sysvmsg \
		sysvsem \
		sysvshm \
		intl \
	; \
	\
# reset apt-mark's "manual" list so that "purge --auto-remove" will remove all build dependencies
	apt-mark auto '.*' > /dev/null; \
	apt-mark manual $savedAptMark; \
	ldd "$(php -r 'echo ini_get("extension_dir");')"/*.so \
		| awk '/=>/ { print $3 }' \
		| sort -u \
		| xargs -r dpkg-query -S \
		| cut -d: -f1 \
		| sort -u \
		| xargs -rt apt-mark manual; \
	\
	apt-get purge -y --auto-remove -o APT::AutoRemove::RecommendsImportant=false; \
	rm -rf /var/lib/apt/lists/*

# set recommended PHP.ini settings
# see https://secure.php.net/manual/en/opcache.installation.php
RUN { \
		echo 'memory_limit=1024M'; \
		echo 'output_buffering=Off'; \
		echo 'upload_max_filesize=1G'; \
		echo 'post_max_size=1G'; \
		echo 'opcache.enable_cli=1'; \
		echo 'opcache.memory_consumption=1024'; \
		echo 'opcache.interned_strings_buffer=8'; \
		echo 'opcache.max_accelerated_files=6000'; \
		echo 'opcache.revalidate_freq=60'; \
		echo 'opcache.fast_shutdown=1'; \
		echo 'error_reporting=E_ALL'; \
		echo 'error_log=/var/log/php_errors.log'; \
	} > /usr/local/etc/php/conf.d/opcache-recommended.ini

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
	php composer-setup.php && \
	mv composer.phar /usr/local/bin/composer && \
	php -r "unlink('composer-setup.php');"

WORKDIR /var/www/html
COPY . /var/www/html
RUN mkdir /var/www/html/logs

ENV COMPOSER_MEMORY_LIMIT=-1
RUN composer install --optimize-autoloader --no-interaction

RUN mkdir -p /var/www/html/vendor/CakeDC/Auth/Social/Mapper
RUN mkdir -p /var/www/html/vendor/cakedc/users/src/Controller/Traits
RUN mkdir -p /var/www/html/vendor/cakedc/users/src/Model/Table
RUN mkdir -p /var/www/html/vendor/cakedc/users/src/Model/Behavior
RUN mkdir -p /var/www/html/vendor/cakedc/users/src/Model/Entity
RUN cp /var/www/html/config/tocopy/AzureMapper.php /var/www/html/vendor/cakedc/auth/src/Social/Mapper/Azure.php
RUN cp /var/www/html/config/tocopy/ProfileTrait.php /var/www/html/vendor/cakedc/users/src/Controller/Traits/ProfileTrait.php
RUN cp /var/www/html/config/tocopy/Azure.php /var/www/html/vendor/thenetworg/oauth2-azure/src/Provider/Azure.php
RUN cp /var/www/html/config/tocopy/UsersTable.php /var/www/html/vendor/cakedc/users/src/Model/Table/UsersTable.php
RUN cp /var/www/html/config/tocopy/SocialBehavior.php /var/www/html/vendor/cakedc/users/src/Model/Behavior/SocialBehavior.php
RUN cp /var/www/html/config/tocopy/SimpleCrudTrait.php /var/www/html/vendor/cakedc/users/src/Controller/Traits/SimpleCrudTrait.php
RUN cp /var/www/html/config/tocopy/UserEntities.php /var/www/html/vendor/cakedc/users/src/Model/Entity/User.php
RUN chown -R www-data:www-data *

USER root

RUN apt-get install -o Dpkg::Options::="--force-confold" -y -q --no-install-recommends && apt-get clean -y \
  ca-certificates \
	libcurl4-openssl-dev \
	libgd-tools \
	libmcrypt-dev \
	git \
	default-mysql-client \
	vim \
	wget \
	&& apt-get autoremove

# RUN /usr/local/bin/php index.php
# RUN cp config/sync/apache2.conf /etc/apache2/apache2.conf
EXPOSE 8080
RUN sed -i 's/80/8080/g' /etc/apache2/ports.conf
RUN cp /usr/local/etc/php/php.ini-development /usr/local/etc/php/php.ini
RUN apt-get update
RUN apt-get install -y netcat
RUN service apache2 restart