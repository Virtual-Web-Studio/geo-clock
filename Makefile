php_version := 8.4
image_name := geo-clock-test
uid := $(shell id -u)
gid := $(shell id -g)

.PHONY: build test install

# Сборка образа, если его ещё нет
build:
	@docker image inspect $(image_name) > /dev/null 2>&1 || \
	docker build -t $(image_name) --build-arg PHP_VERSION=$(php_version) --build-arg UID=$(uid) --build-arg GID=$(gid) .

validate:
	docker run --rm -v $(PWD):/app -w /app composer:2.6 validate

install: build
	docker run --rm -u $(uid):$(gid) -v $(PWD):/app -w /app $(image_name) composer install --no-interaction --prefer-dist

test: build
	docker run --rm -u $(uid):$(gid) -v $(PWD):/app -w /app $(image_name) vendor/bin/phpunit $(ARGS)
