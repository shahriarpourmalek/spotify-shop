DOCKER_ENV ?= .env.docker
COMPOSE ?= docker compose --env-file $(DOCKER_ENV)
APP_SERVICE ?= app

.PHONY: build up down restart logs shell composer artisan migrate fresh seed test pint stan

build:
	$(COMPOSE) build

up:
	$(COMPOSE) up -d

down:
	$(COMPOSE) down

restart:
	$(COMPOSE) restart

logs:
	$(COMPOSE) logs -f

shell:
	$(COMPOSE) exec $(APP_SERVICE) sh

composer:
	$(COMPOSE) exec $(APP_SERVICE) composer $(filter-out $@,$(MAKECMDGOALS))

artisan:
	$(COMPOSE) exec $(APP_SERVICE) php artisan $(filter-out $@,$(MAKECMDGOALS))

migrate:
	$(COMPOSE) exec $(APP_SERVICE) php artisan migrate

fresh:
	$(COMPOSE) exec $(APP_SERVICE) php artisan migrate:fresh

seed:
	$(COMPOSE) exec $(APP_SERVICE) php artisan db:seed

test:
	$(COMPOSE) exec $(APP_SERVICE) php artisan test

pint:
	$(COMPOSE) exec $(APP_SERVICE) ./vendor/bin/pint

stan:
	$(COMPOSE) exec $(APP_SERVICE) ./vendor/bin/phpstan analyse

%:
	@:
