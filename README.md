### Требования
- Docker
- Docker Compose
- Make (для использования Makefile)

### Установка
1. Клонируйте репозиторий:
   ```bash
   git clone https://github.com/Shaglem/pizza.git
   cd pizza
   ```
2. Запустите команду из корня проекта
    ```bash
   make setup
    ```
   
### Список команд
- make setup — Первый запуск проекта.
- make up — Запуск Docker-контейнеров.
- make down — Остановка Docker-контейнеров.
- make build — Пересборка контейнеров.
- make migrate — Применение миграций.
- make test — Запуск тестов.
