CONTAINER_NAME=php_container
CONTAINER_CMD=docker exec -it $(CONTAINER_NAME)
COMPOSER_CMD=$(CONTAINER_CMD) composer
PHP_CMD=$(CONTAINER_CMD) php
COMPOSER_FILE=docker-compose.yml

composer-install:
	$(COMPOSER_CMD) install --optimize-autoloader --ignore-platform-req=ext-openswoole

composer-update:
	$(COMPOSER_CMD) update

composer-require:
	@read -p "Enter the library to require (e.g. symfony/var-dumper): " library; \
	$(COMPOSER_CMD) require $$library --ignore-platform-req=ext-openswoole

composer-dump-autoload:
	$(COMPOSER_CMD) dump-autoload

docker-shell:
	$(CONTAINER_CMD) /bin/bash

docker-build:
	docker-compose up -d --build
	@$(MAKE) composer-install

docker-clean:
	docker-compose down -v

docker-stop:
	docker-compose stop

docker-start:
	docker-compose start

docker-logs:
	docker-compose logs -f $(CONTAINER_NAME)

clear-cache:
	$(PHP_CMD) bin/console cache:clear

debug-command:
	$(PHP_CMD) bin/console debug:container --tag=app.command_handler

debug-router:
	$(PHP_CMD) bin/console debug:router

test-unit:
	$(PHP_CMD) bin/phpunit $(filter-out $@,$(MAKECMDGLOBALS))

migration-status:
	$(PHP_CMD) ./vendor/bin/doctrine-migrations status

migration-generate:
	$(PHP_CMD) ./vendor/bin/doctrine-migrations generate

migrations-migrate:
	$(PHP_CMD) ./vendor/bin/doctrine-migrations migrate $(filter-out $@,$(MAKECMDGLOBALS))

.PHONY: cs-fixer
cs-fixer:
	@read -p "Route to fix: " route; \
	$(PHP_CMD) ./vendor/bin/php-cs-fixer fix --verbose $$route

.PHONY: cs-fixer-all
cs-fixer-all:
	$(PHP_CMD) ./vendor/bin/php-cs-fixer fix --verbose src/

.PHONY: cs-fixer-precommit
cs-fixer-precommit:
	@FILES=$$(git diff --name-only --diff-filter=d | grep -E '\.php');
	if [ -z $$FILES ]; then \
  		echo "No PHP files to fix"; \
  		exit 0; \
	else \
	  	for FILE in $$FILES; do \
	  	  	$(PHP_CMD) ./vendor/bin/php-cs-fixer fix --verbose $$FILE; \
		done \
	fi \
