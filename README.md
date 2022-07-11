Первичный запуск приложения:
    make init

Запуск тестов:
    make test

Пользователи из фикстур, созданные в БД после запуска приложения:
    id - 00000000-0000-0000-0000-000000000001
    id - 00000000-0000-0000-0000-000000000002

Эндпоинт для транзакции:
    POST http://api.localhost/V1/transaction/transfer-from-user
JSON параметры запроса:
    {"fromUserId":"uuid","toUserId":"uuid","amount":"float"}