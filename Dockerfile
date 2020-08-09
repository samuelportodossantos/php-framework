FROM php:7.4-apache
RUN docker-php-ext-install pdo pdo_mysql

# Instalando composer
RUN cd ~; curl -sS https://getcomposer.org/installer -o composer-setup.php;php composer-setup.php --install-dir=/usr/local/bin --filename=composer

# Instalando xdebug
RUN apt-get update -y && apt-get install wget -y
RUN wget -c -P ~/Downloads http://xdebug.org/files/xdebug-2.9.6.tgz
RUN cd ~/Downloads; tar -xvzf ~/Downloads/xdebug-2.9.6.tgz
RUN cd ~/Downloads/xdebug-2.9.6/; phpize
RUN cd ~/Downloads/xdebug-2.9.6/; sh configure; 
RUN cd ~/Downloads/xdebug-2.9.6/; make; 
RUN cp ~/Downloads/xdebug-2.9.6/modules/xdebug.so /usr/local/lib/php/extensions/no-debug-non-zts-20190902
RUN echo 'zend_extension = /usr/local/lib/php/extensions/no-debug-non-zts-20190902/xdebug.so' >> /usr/local/etc/php/php.ini