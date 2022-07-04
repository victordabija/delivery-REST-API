# delivery-REST-API

---
## Регистрация клиента в API

### URL: https://domain/api/new_user
### Тип запроса: POST

### Тело запроса 
```json
{
    "name": "Popov Oleg",
    "password": "abc123"
}
```

| Поле          | Обязательное  | Формат|    Описание|
|:-------------:|:-------------:|:-----:|:----------:|
| name          | да            | string| имя/фамилия пользователя |
| password      | да            | string| пароль пользователя |

### Успешный ответ
```json
{
    "name": "Popov Oleg",
    "password": "abc123",
    "user_id": 13,
    "code": 200
}
```

### Ответ с ошибкой
```json
{
    "code": 400,
    "message": "Bad Request"
}
```

---
## Расчет стоимости доставки

### URL: https://domain/api/calculate
### Тип запроса: POST

### Тело запроса
```json
{
  "distance": 100,  
  "weight": 5500
}
```

| Поле          | Обязательное  | Формат|    Описание|
|:-------------:|:-------------:|:-----:|:----------:|
| distance      | да            | string| расстояние, км |
| weight        | да            | string| масса посылки, граммы |


### Успешный ответ
```json
{
    "code": 200,
    "delivery_cost": 100
}
```
### Ответ с ошибкой
```json
{
    "code": 400,
    "message": "Bad Request"
}
```
```json
{
    "code": 400,
    "message": "Parameters have to be type int"
}
```

---
## Создание заказа

### URL: https://domain/api/create
### Тип запроса: POST

### Тело запроса

```json
{
    "user_id": 5,
    "password": "tester",
    "from": "Los Altos",
    "to": "Miami",
    "distance": 150,
    "weight": 23450,
    "first_name": "Test",
    "last_name": "Name",
    "email": "name@gmail.com",
    "phone": "+0000000",
    "zip_code": "US-0000"
}
```

| Поле          | Обязательное  | Формат|    Описание|
|:-------------:|:-------------:|:-----:|:----------:|
| user_id       | да            | int   | уникальный идентификатор пользователя |
| password      | да            | string| пароль пользователя |
| from          | да            | string| откуда отправилась посылка |
| to            | да            | string| куда отправляется посылка |
| distance      | да            | string| расстояние, км |
| weight        | да            | string| масса посылки, граммы |
| first_name    | да            | string| фамилия получателя |
| last_name     | да            | string| имя получателя |
| email         | да            | string| email получателя |
| phone         | да            | string| номер телефона получателя |
| zip_code      | да            | string| почтовый индекс получателя |

### Успешный ответ
```json
{
    "code": 200,
    "order_id": 17,
    "delivery_cost": 160
}
```

### Ответ с ошибкой
```json
{
    "code": 400,
    "message": "Bad Request"
}
```

```json
{
    "code": 400,
    "message": "Authorization Failed. Incorrect Password"
}
```

```json
{
    "code": 400,
    "message": "Authorization Failed. No User With Given ID"
}
```

---
## Получение информации о заказе

### URL: https://domain/api/get_order
### Тип запроса: POST

### Тело запроса 

```json
{
    "user_id": 5,
    "password": "tester",
    "order_id": 16
}
```

| Поле          | Обязательное  | Формат|    Описание|
|:-------------:|:-------------:|:-----:|:----------:|
| user_id       | да            | int   | уникальный идентификатор пользователя |
| password      | да            | string| пароль пользователя |
| order_id      | да            | int   | уникальный идентификатор заказа |

### Успешный ответ
```json
{
    "order_id": "16",
    "user_id": "5",
    "distance": "150",
    "from": "Los Altos",
    "to": "Miami",
    "weight": "23450",
    "first_name": "Test",
    "last_name": "Name",
    "email": "name@gmail.com",
    "phone": "+0000000",
    "zip_code": "US-0000",
    "delivery_cost": "160",
    "status": "On the Way",
    "order_date": "2022-07-03 22:34:59"
}
```
```json
{
    "code": 200,
    "message": "No Orders With Given ID"
}
```

### Ответ с ошибкой
```json
{
    "code": 400,
    "message": "Bad Request"
}
```

```json
{
    "code": 400,
    "message": "Authorization Failed. No User With Given ID"
}
```

```json
{
    "code": 400,
    "message": "Authorization Failed. Incorrect Password"
}
```

---
## Получение списка заказов

### URL: https://domain/api/get_orders
### Тип запроса: POST

### Тело запроса 
```json
{
    "user_id": 5,
    "password": "tester"
}
```

| Поле          | Обязательное  | Формат|    Описание|
|:-------------:|:-------------:|:-----:|:----------:|
| user_id       | да            | int   | уникальный идентификатор пользователя |
| password      | да            | string| пароль пользователя |

### Успешный ответ
```json
[
    {
        "order_id": "1",
        "user_id": "5",
        "distance": "120",
        "from": "Chisinau",
        "to": "Edinet",
        "weight": "5500",
        "first_name": "Popova",
        "last_name": "Valeria",
        "email": "popova@gmail.com",
        "phone": "+37300000000",
        "zip_code": "MD-1228",
        "delivery_cost": "136",
        "status": "On the Way",
        "order_date": "2022-07-03 22:04:55"
    },
    {
        "order_id": "17",
        "user_id": "5",
        "distance": "150",
        "from": "Los Altos",
        "to": "Miami",
        "weight": "23450",
        "first_name": "Test",
        "last_name": "Name",
        "email": "name@gmail.com",
        "phone": "+0000000",
        "zip_code": "US-0000",
        "delivery_cost": "160",
        "status": "On the Way",
        "order_date": "2022-07-04 10:33:39"
    }
]
```

```json
{
    "code": 200,
    "message": "User With Given ID doesn`t have orders"
}
```

### Ответ с ошибкой
```json
{
    "code": 400,
    "message": "Bad Request"
}
```

```json 
{
    "code": 400,
    "message": "Authorization Failed. No User With Given ID"
}
```

```json
{
    "code": 400,
    "message": "Authorization Failed. Incorrect Password"
}
```

## База данных 
Все таблицы будут созданы через SQL запросы в файле db.sql
