*** RESTful API
=======================

**Postman local**: ***

**Postman global**: ***


Objects
==========


## User

**Fields**

| name      | type                              | about                         | need? |
|-----------|-----------------------------------|-------------------------------|-------|
| uid       | char(36)                          | PK                            | +     |
| login     | string(100)                       | Login для входа               | +     |
| fio       | string(100)                       | ФИО для отображения           | +     |
| createdAt | dateTime(yyyy-MM-dd HH:mm:ssZ)    | Дата регистрации пользователя |       |


## AccessToken

**Fields**

| name      | type      | about                 | need? |
|-----------|-----------|-----------------------|-------|
| uid       | char(36)  | PK                    | +     | 
| user      | [User]    | Auth User object      | +     |
| ttl       | int       | Время жизни сессии    | +     |
| userUid   | char(36)  | FK [User]             |       |

## Travel

**Fields**

| name          | type                              | about                                                         | need? |
|---------------|-----------------------------------|---------------------------------------------------------------|-------|
| uid           | char(36)                          | PK                                                            | +     |
| ttUid         | char(36)                          | FK [TT], uid ТТ                                               | +     |
| userUid       | char(36)                          | FK [User], uid пользователя, который будет выполнять заказ    | +     |
| travelDate    | date(yyyy-MM-dd)                  | Назначенное время на выезд                                    | +     |
| status        | tinyint                           | Статус                                                        | +     |
| statusText    | string                            | Текстовое описание статуса                                    | +     |
| templateUid   | char(36)                          | FK [Template], uid шаблона                                    |       |
| createdAt     | dateTime(yyyy-MM-dd HH:mm:ssZ)    | Время создания                                                |       |
| tt            | [TT]                              | ТТ, на которую поставлена задача                              | +     |

**Expand**

| name              | type              | about                                                             | need? |
|-------------------|-------------------|-------------------------------------------------------------------|-------|
| params            | json              | Дополнительные параметры из файла загрузки                        |       |
| template          | [Template]        | Шаблон, по которому установлена задача                            |       |
| media             | [Media][]         | Массив прикрепленных media файлов                                 | +     |
| implementation    | [Implementation]  | Выполнение заказа                                                 | +     |
| user              | [User]            | Объект пользователя мерчендайзера, который будет выполнять заказ  |       |

## Travel Media

**Fields**

| name          | type                              | about                 | need? |
|---------------|-----------------------------------|-----------------------|-------|
| uid           | char(36)                          | PK                    | +     |
| travelUid     | char(36)                          | FK [Travel]           | +     |
| mime          | string(255)                       | File mime type        | +     |
| size          | int                               | File size             | +     |
| url           | string(255)                       | File url              | +     |
| comment       | string(255)                       | Комментарий к файлу   | +     |
| createdAt     | dateTime(yyyy-MM-dd HH:mm:ssZ)    | Время загрузки файла  |       |