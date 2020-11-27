export COMPOSE_PROJECT_NAME=cmp-video-importer

all: up setup tests

up:
	docker-compose -f docker/docker-compose.yml up -d

setup:
	docker-compose -f docker/docker-compose.yml exec php sh -c "/usr/local/bin/composer install --prefer-dist"

down:
	docker-compose -f docker/docker-compose.yml down

clean:
	docker-compose -f docker/docker-compose.yml down --rmi all -v

enter:
	docker-compose -f docker/docker-compose.yml exec php sh

import:
	docker-compose -f docker/docker-compose.yml exec php sh -c "./bin/console import ${provider}"

logs:
	docker-compose -f docker/docker-compose.yml logs -f php

tests: tests-unit tests-end-to-end

tests-unit:
	docker-compose -f docker/docker-compose.yml exec php sh -c "./vendor/bin/phpunit --testsuite Unit"

tests-end-to-end:
	docker-compose -f docker/docker-compose.yml exec php sh -c "./vendor/bin/phpunit --testsuite EndToEnd"