To start the server do command:
```
docker compose up -d
```
Server will start on http://127.0.0.1:8082

Endpoints:

`GET http://127.0.0.1:8082/team` - get all teams, no parameters
<br/>
`POST http://127.0.0.1:8082/team` - create a new team, parameters (in JSON):
<br/>
<br/>
`GET http://127.0.0.1:8082/team/{id}` - get one team (by id), no parameters
<br/>
`PUT http://127.0.0.1:8082/team/{id}` - update one team (by id), parameters (in JSON): `name`
<br/>
<br/>
`DELETE http://127.0.0.1:8082/team/{id}` - delete one team (by id), no parameters
<br/>
<br/>
<br/>
`GET http://127.0.0.1:8082/counter` - get all counters, no parameters
<br/>
`POST http://127.0.0.1:8082/counter` - create a new counter, parameters (in JSON): `teamId`
<br/>
<br/>
`GET http://127.0.0.1:8082/counter/{id}` - get one counter (by id), no parameters
<br/>
`DELETE http://127.0.0.1:8082/counter/{id}` - delete one counter (by id), no parameters
<br/>
<br/>
`PUT http://127.0.0.1:8082/counter/{id}/increment` - increment steps in one counter (by id), no parameters
