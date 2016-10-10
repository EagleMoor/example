Chronology GPS
===============

Хронология по GPS

**Request**

```
GET cars/{carUid}/chronology/gps                            — хронология за текущий день
GET cars/{carUid}/chronology/gps?day={day}                  — хронология за {day} день
GET cars/{carUid}/chronology/gps?start={start}&stop={stop}  — хронология c {start} по {stop} времени
 
GET cars/08c9f4a3-a0ad-58e7-984a-7ed5aeb1370b/chronology/gps
```

**Params**

`{day}` — День. Имеет формат `timestamp` или `Y-m-d` <br/>
`{start}, {stop}` — День начала и конца. Имеет формат `timestamp` или `yyyy-MM-dd HH:mm:ssZ`

**Response**

`STATUS: 200`
```json
{
  "gpsLines": [
    {
      "start": 1474961190,
      "stop": 1474961812,
      "count": 451,
      "duration": 622
    },
    {
      "start": 1474962479,
      "stop": 1474962729,
      "count": 145,
      "duration": 250
    },
    {
      "start": 1474966256,
      "stop": 1474978634,
      "count": 11327,
      "duration": 12378
    }
  ]
}
```