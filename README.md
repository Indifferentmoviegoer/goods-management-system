# goods-management-system
 - Скопировать и переопределить переменные окружения  `cp .env .env.local` 
 - Запустить сборку проекта `docker-compose up -d`
 - Подтянуть зависимости `docker-compose exec php composer install`
 - Применить миграции `docker-compose exec php bin/console doctrine:migrations:migrate`
 - Запустить тесты `make tests`
 - Сгенерировать отчет по генерации покрытия тестами `docker-compose exec php bin/phpunit --coverage-html ./templates/coverage`