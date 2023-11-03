#!/bin/bash
RABBIT = ${DOCKER_NAME}-rabbitmq
UID = $(shell id -u)

help: ## Show this help message
	@echo 'usage: make [target]'
	@echo
	@echo 'targets:'
	@egrep '^(.+)\:\ ##\ (.+)' ${MAKEFILE_LIST} | column -t -c 2 -s ':#'

up: ## Start the containers
	docker network create udemyapiplatform-network || true
	U_ID=${UID} docker-compose up -d

stop: ## Stop the containers
	U_ID=${UID} docker-compose stop

restart: ## Restart the containers
	$(MAKE) stop && $(MAKE) up

build: ## Rebuilds all the containers
	U_ID=${UID} docker-compose build

ssh: ## Container's Bash
	U_ID=${UID} docker exec -it --user ${UID} ${RABBIT} bash
