# Дипломный проект - серверная часть

Серверная часть проекта реализована на Laravel. Она предоставляет набор открытых и закрытых API для работы с залами, фильмами, сеансами и билетами. 

## Структура проекта
Общий процесс обработки запроса можно представить цепочкой:
Route -> Request -> Controller -> Repository -> Database

### Маршруты: routes/api.php
* /api/films - работа с фильмами
* /api/halls - работа с залами
* /api/seances - работа с сеансами
* /api/tickets - работа с билетами
* /api/token - выпуск и отмена токена

### Запоросы: app/Http/Requests
В запросах осуществляется валидация данных:
* ApiTokenRequest - аутентификация и выпуск токена
* FilmCreateRequest - создание фильма
* HallCreateRequest - создание зала
* HallUpdateRequest - обновление данных зала
* SeanceCreateRequest - создание сеанса
* TicketCreateRequest - создание билета

### Контроллеры: app/Http/Controllers
Контроллеры не содержат логики, а вызывают соответствующие методы репозиториев.
* ApiTokenController 
* FilmController
* HallController
* SeanceController
* TicketController

### Интерфейсы
Описывают сигнатуры репозиториев. Находятся в папке app/Interfaces.

### Репозитории
В репозиториях находится основная логика работы с сущностями. Из них осуществляется работа с базой данных. Репозитории могут использовать методы других репозиториев. В репозиториях выбрасываются исключения, связанные с работой с базой данных.
* FilmRepository
* HallRepository
* SeanceRepository
* TicketRepository

### Исключения
Для всех ошибок базы данных создано одно CustomDatabaseException - расположено в app/Exceptions. В ответы на ошибку оно отправляет JSON с данными и статусом 500.

### База данных
Для простоты используется sqlite. Первоначальная настройка осуществляется миграциями и сидированием. Таблицы в базе связанные: сеансы зависят от фильмов и залов, билеты зависят от сеансов. Это учтено в логике работы репозиториев: удаление узловых сущностей происходит после предварительного удаления связанных.

## Запуск приложения

1) выполнить composer install 
2) проверить путь к БД в env.
3) сделать миграции и наполнить базу: migration:refresh --seed
4) запустить php artisan serve

В текущих настройках сидирования данные тестового пользователя-администратора:
* имя пользователя: test
* почта: test@test.ru
* пароль: test
