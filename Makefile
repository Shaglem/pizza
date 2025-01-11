# Переменные
DOCKER_COMPOSE = ./vendor/bin/sail

# Задачи
setup:
	@echo "Установка проекта..."
	composer install
	cp .env.example .env
	php artisan key:generate
	$(DOCKER_COMPOSE) up -d
	$(DOCKER_COMPOSE) php artisan migrate:fresh --seed
	@echo "Проект готов!"

up:
	@echo "Запуск контейнеров..."
	$(DOCKER_COMPOSE) up -d

down:
	@echo "Остановка контейнеров..."
	$(DOCKER_COMPOSE) down

build:
	@echo "Пересборка контейнеров..."
	$(DOCKER_COMPOSE) build

migrate:
	@echo "Применение миграций..."
	$(DOCKER_COMPOSE) php artisan migrate

test:
	@echo "Запуск тестов..."
	$(DOCKER_COMPOSE) php artisan test --profile
