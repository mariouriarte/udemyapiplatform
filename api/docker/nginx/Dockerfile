FROM nginx:1.24-alpine as base

RUN echo 'config nginx';
#RUN addgroup appuser www-data

FROM base as dev
COPY docker/nginx/default.conf /etc/nginx/conf.d/

#FROM base as prod
#COPY docker/nginx/default.prod.conf /etc/nginx/conf.d/default.conf
