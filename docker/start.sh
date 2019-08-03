#!/bin/bash
( cd ../src && npm install && composer install && yarn encore dev )
COMPOSE_HTTP_TIMEOUT=100000 docker-compose up
