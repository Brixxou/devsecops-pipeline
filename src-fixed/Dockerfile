FROM php:8.3-apache
RUN docker-php-ext-install mysqli pdo pdo_mysql
# Security headers via Apache
RUN a2enmod headers && \
    echo 'Header always set X-Content-Type-Options "nosniff"' >> /etc/apache2/conf-available/security-headers.conf && \
    echo 'Header always set X-Frame-Options "DENY"' >> /etc/apache2/conf-available/security-headers.conf && \
    echo 'Header always set X-XSS-Protection "1; mode=block"' >> /etc/apache2/conf-available/security-headers.conf && \
    echo 'Header always unset X-Powered-By' >> /etc/apache2/conf-available/security-headers.conf && \
    echo 'ServerTokens Prod' >> /etc/apache2/conf-available/security-headers.conf && \
    a2enconf security-headers
COPY . /var/www/html/
