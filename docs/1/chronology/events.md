Chronology Events
===============

Хронология по событиям

**Request**

```
GET cars/{carUid}/chronology/events                            — хронология за текущий день
GET cars/{carUid}/chronology/events?day={day}                  — хронология за {day} день
GET cars/{carUid}/chronology/events?start={start}&stop={stop}  — хронология c {start} по {stop} времени
GET cars/{carUid}/chronology/events?types={type1},{type2},..   — хронология по типам
 
GET cars/03ad8a70-63c4-4605-8a10-bc3da94d35a3/chronology/events
```

**Params**

`{day}` — День. Имеет формат `timestamp` или `Y-m-d` <br/>
`{start}, {stop}` — День начала и конца. Имеет формат `timestamp` или `yyyy-MM-dd HH:mm:ssZ` <br/>
`types` — Перечисление типов событий, которые хотим получить. Перечисление производится через запятую, например
`events?types=b5ec2f1e-eb64-5dd1-b871-a3301d9de771,9d4df5cb-c729-5100-8789-1b1a25bff595`

**Response**

`STATUS: 200`
```json
{
    "types": [
        {
            "uid": "b5ec2f1e-eb64-5dd1-b871-a3301d9de771",
            "name": "offline",
            "description": "Автомобиль оффлайн"
        },
        {
            "uid": "9d4df5cb-c729-5100-8789-1b1a25bff595",
            "name": "online",
            "description": "Автомобиль онлайн"
        }
    ],
    "eventLines": [
        {
            "type_uid": "b5ec2f1e-eb64-5dd1-b871-a3301d9de771",
            "events": [
                {
                    "time": 1475074864,
                    "value": 0
                },
                {
                    "time": 1475076035,
                    "value": 0
                },
                {
                    "time": 1475076137,
                    "value": 0
                }
            ],
            "count": 39
        },
        {
            "type_uid": "9d4df5cb-c729-5100-8789-1b1a25bff595",
            "events": [
                {
                    "time": 1475074897,
                    "value": 0
                },
                {
                    "time": 1475076107,
                    "value": 0
                }
            ],
            "count": 39
        }
    ]
}
```

**Описание структуры**

```
types           AlarmType[]         — Описание всех типов событий, которые присутствуют в выборке
eventLines      array               — Списки сгруппированных по типу событий
    type_uid    char(36)            — uuid типа событий
    events      Events[]            — Массив событий данного типа
        time    timestamp           — Время события (в timestamp проще делать вычисления для отображения)
        value   float               — Значение. Например событие "Привышение скорости" и значение на сколько привысил
    count       int                 — Суммарное кол-во событий данного типа
```