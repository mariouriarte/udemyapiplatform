#!/bin/bash
include .env

UID = $(shell id -u)
DOCKER_BE = udemyapiplatform-app

help: ## Show this help message
	@echo 'usage: make [target]'
	@echo
	@echo 'targets:'
	@egrep '^(.+)\:\ ##\ (.+)' ${MAKEFILE_LIST} | column -t -c 2 -s ':#'

# >>>> dev
build: ## Rebuilds all the containers
	USERID=${UID} docker-compose build

up: ## Up the containers
	docker network create udemyapiplatform-network || true
	USERID=${UID} docker-compose up -d

stop: ## Stop the containers
	USERID=${UID} docker-compose stop

rebuild: ## Restart the containers
	$(MAKE) stop && $(MAKE) build

bash: ## bash into the be container
	USERID=${UID} docker exec -it --user ${UID} ${DOCKER_BE} bash

# Backend commands
logs: ## Show Symfony logs in real time
	USERID=${UID} docker exec -it --user ${UID} ${DOCKER_BE} symfony server:log

composer-install: ## Installs composer dependencies
	USERID=${UID} docker exec --user ${UID} -it ${DOCKER_BE} composer install --no-interaction

migrations: ## Runs the migrations
	USERID=${UID} docker exec --user ${UID} -it ${DOCKER_BE} bin/console doctrine:migrations:migrate -n

generate-ssh-keys: ## generate ssh keys
	USERID=${UID} docker exec --user ${UID} -it ${DOCKER_BE} mkdir -p config/jwt
	USERID=${UID} docker exec --user ${UID} -it ${DOCKER_BE} openssl genrsa -passout pass:${JWT_PASSPHRASE} -out config/jwt/private.pem -aes256 4096
	USERID=${UID} docker exec --user ${UID} -it ${DOCKER_BE} openssl rsa -pubout -passin pass:${JWT_PASSPHRASE} -in config/jwt/private.pem -out config/jwt/public.pem
