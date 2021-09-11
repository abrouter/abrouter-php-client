FROM webdevops/php-nginx:7.4 as abr-php-client

COPY . /app

EXPOSE 80

WORKDIR /app
