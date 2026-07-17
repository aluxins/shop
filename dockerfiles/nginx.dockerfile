FROM nginx:1.26-alpine

COPY ./nginx/default.conf /etc/nginx/conf.d/default.conf

RUN mkdir -p /var/www/html
