# Utilise une image de base PHP avec Apache
FROM php:8.2-apache

# Installation des extensions PHP nécessaires
RUN apt-get update && apt-get install -y libcurl4-openssl-dev pkg-config libssl-dev \
    && pecl install mongodb \
    && docker-php-ext-enable mongodb \
    && docker-php-ext-install pdo pdo_mysql

# Ajout d'un ServerName pour éviter les warnings
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Activer le module rewrite pour Apache
RUN a2enmod rewrite

# Activer l'affichage des erreurs pour le développement
RUN echo "display_errors=On" >> /usr/local/etc/php/conf.d/docker-php.ini

# Création du répertoire de logs Apache
RUN mkdir -p /var/log/apache2 && \
    chown -R www-data:www-data /var/log/apache2 && \
    chmod -R 755 /var/log/apache2

# Copie des fichiers de l'application dans le conteneur
COPY . /var/www/html/

# Définit les permissions et le répertoire de travail
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Expose le port 80 pour accéder à l'application
EXPOSE 80

RUN curl -sS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer

