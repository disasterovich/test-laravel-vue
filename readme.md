Тестовое задание. laravel+vue

## Установка

1. клонируем проект с github

```
git clone https://github.com/disasterovich/test-laravel-vue.git
```

2. Создаем БД, прописываем свои логин, пароль, имя бд. (в файле .env)

3. Выполняем миграции:

```
php artisan migrate
```

4. Заполняем таблицу books данными:

```
php artisan db:seed
```

5. запускаем встроенный web-сервер

```
php artisan serve
```

6. открываем браузер ( http://localhost:8000/ )