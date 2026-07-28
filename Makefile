DOCKER ?= docker
COMPOSE ?= $(DOCKER) compose

MYSQL_SERVICE ?= mysql
INITIAL_DB_PATH ?= database/db/initial_db.sql

# Load .env for Make variables (DB_*, etc.)
ifneq (,$(wildcard .env))
include .env
export
endif

.PHONY: build up down restart logs shell migrate seed test composer-install init-db

build:
	$(COMPOSE) build

up:
	$(COMPOSE) up -d

down:
	$(COMPOSE) down

restart: down up

logs:
	$(COMPOSE) logs -f

shell:
	$(COMPOSE) exec app bash

migrate:
	$(COMPOSE) exec app php artisan migrate --force

seed:
	$(COMPOSE) exec app php artisan db:seed --force

test:
	$(COMPOSE) exec app php artisan test

composer-install:
	$(COMPOSE) run --rm app composer install --no-interaction --prefer-dist --optimize-autoloader

init-db:
	$(DOCKER) exec -i -u root $$($(COMPOSE) ps -q $(MYSQL_SERVICE)) \
		mysql -u root -p"$(DB_ROOT_PASSWORD)" "$(DB_DATABASE)" \
		--init-command="SET SESSION sql_mode=REPLACE(@@SESSION.sql_mode,'NO_ZERO_DATE',''); \
		                SET SESSION sql_mode=REPLACE(@@SESSION.sql_mode,'NO_ZERO_IN_DATE',''); \
		                SET SESSION sql_mode=REPLACE(@@SESSION.sql_mode,'STRICT_TRANS_TABLES','');" \
		< "$(INITIAL_DB_PATH)"
