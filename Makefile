SHELL := /bin/bash

tests:
	docker-compose exec php bin/console doctrine:database:drop --force --env=test || true
	docker-compose exec php bin/console doctrine:database:create --env=test
	docker-compose exec php bin/console doctrine:migrations:migrate -n --env=test
	docker-compose exec php bin/phpunit --coverage-html ./coverage
.PHONY: tests