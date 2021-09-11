APP = abr-php-client

.PHONY: up
up:
	docker-compose up -d

.PHONY: down
down:
	docker-compose down

.PHONY: stop
stop:
	docker-compose stop

.PHONY: test-run
test-run:
	docker exec -it $(APP) php vendor/bin/phpunit

.PHONY: bash
bash:
	docker exec -it $(APP) bash
