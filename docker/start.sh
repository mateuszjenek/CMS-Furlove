#!/bin/bash
{cd ../src && npm install && composer install && yarn encore dev}
docker-compose up
