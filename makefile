system-init:
	cp -n .env.local.sample .env.local
	make run
	make composer install

run: .env
	docker-compose --env-file .env up -d

down:
	docker-compose down

stop:
	docker-compose stop

composer:
	docker-compose exec php-fpm composer $(filter-out $@,$(MAKECMDGOALS))

bash:
	docker-compose exec php-fpm bash

clear-cache:
	docker-compose exec php-fpm rm -rf var/cache

lintfix: .php-cs-fixer.dist.php
	docker-compose exec -- php-fpm ./vendor/bin/php-cs-fixer fix src --config .php-cs-fixer.dist.php

phpstan:
	docker-compose exec php-fpm ./vendor/bin/phpstan

console:
	docker-compose -f docker-compose.yml exec php-fpm ./bin/console $(filter-out $@,$(MAKECMDGOALS))

fix-owner:
	sudo find src/ bin/ config/ var/ vendor/ migrations/ -user root -exec chown ${USER}:${USER} {} \;

migrate:
	docker-compose exec php-fpm ./bin/console doctrine:migrations:migrate

migrations-diff:
	docker-compose exec php-fpm ./bin/console doctrine:migrations:diff
