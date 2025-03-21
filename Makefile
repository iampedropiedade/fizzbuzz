PROJECTROOTDIR = $(CURDIR)

build:
	docker compose build

start:
	docker compose up -d --force-recreate

stop:
	docker compose stop

composer:
	docker exec appsconcept-api bash -c "cd /var/www/html && composer install"

migration:
	docker exec appsconcept-api /var/www/html/bin/console make:migration -q

migrate:
	docker exec appsconcept-api /var/www/html/bin/console doctrine:migrations:migrate -q

bash:
	docker -c "cd /var/www/html" && docker exec -it appsconcept-api bash

open:
	open http://localhost:8210/api/doc

test-unit:
	docker exec appsconcept-api /var/www/html/vendor/bin/phpunit

test-phpstan:
	docker exec appsconcept-api /var/www/html/vendor/bin/phpstan analyse

test-phpcs:
	docker exec appsconcept-api /var/www/html/vendor/friendsofphp/php-cs-fixer/php-cs-fixer check

test-phpcs-fix:
	docker exec appsconcept-api /var/www/html/vendor/friendsofphp/php-cs-fixer/php-cs-fixer fix

init:
	$(MAKE) build
	$(MAKE) start
	sleep 20
	$(MAKE) composer
	$(MAKE) migrate
	$(MAKE) open

tests:
	$(MAKE) test-phpcs
	$(MAKE) test-phpstan
	$(MAKE) test-unit
