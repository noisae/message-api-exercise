# Message Api

## Development Concepts

The development of Message Api are based on some concepts, patterns and technics. 
- First of all the application structure are based on Architeture Layer Idea explained by Robert Martin on "[Ruby Midwest 2011 - Keynote: Architecture the Lost Years by Robert Martin](https://www.youtube.com/watch?v=WpkDN78P884)".
- All development proccess are made using [TDD](https://martinfowler.com/bliki/TestDrivenDevelopment.html) and [BDD](https://dannorth.net/introducing-bdd/). TDD for some important Business Rules on specific Classes, and BDD for important system behaviours.
- BDD is used to develop tests like integration, but mocking the repositories.
- Some important concepts of [DDD](https://www.amazon.com.br/Domain-Driven-Design-Tackling-Complexity-Software/dp/0321125215) are used here, like Entity and Service. If that api grow up we can move the logic from Service to Aggregates, creating that with Factories.
- The code write are based on best practices from some concepts like Clean Code, Refactor to Patterns, SOLID, Object Calisthenics, and others.
- [Docker](https://docs.docker.com/compose/install/) are used to run the projects.

## Projects Access
The project run on **localhost:3000**. To access endpoints of **PHP Project** use a HTTP Authorization header **Authorization: Basic YWRtaW46b2Jlcmxv**, this is a Basic Auth with user **admin** and password **oberlo**
```sh
$ curl -X GET \
  http://localhost:3000/message \
  -H 'authorization: Basic YWRtaW46b2Jlcmxv' \
  -H 'cache-control: no-cache'
```
```sh
$ curl -X POST \
  http://localhost:3000/message/21/read \
  -H 'authorization: Basic YWRtaW46b2Jlcmxv' \
  -H 'cache-control: no-cache'
```
### Endpoints
**List:** localhost:3000/message/?page=**{pageNumber}**&limit=**{limitNumber}**
**List Archived:** GET - localhost:3000/message/archived?page=**{pageNumber}**&limit=**{limitNumber}**
**Show Message:** GET - localhost:3000/message/**{uid}**
**Read Message:** POST - localhost:3000/message/**{uid}**/read
**Archive Message:** POST - localhost:3000/message/**{uid}**/archive

## PHP Project
### Run
Run mysql on first time, after that you can run **mysql** and **messageapi** dockers together. Maybe will take some time to run first php composer.
```sh
$ docker-compose up mysql
$ docker-compose up
```
### Tests
```sh
$ docker-compose run --rm messageapi ./vendor/bin/phpunit
$ docker-compose run --rm messageapi ./vendor/bin/behat
```
### DB Migrate and DB Seed
```sh
$ docker-compose run --rm messageapi ./vendor/bin/phinx migrate -e development
$ docker-compose run --rm messageapi./vendor/bin/phinx seed:run -e development
```

## NodeJs Project
### Run
Maybe will take some time to run first npm install.
```sh
$ docker-compose up
```
### DB Migrate and DB Seed
```sh
$ docker-compose run --rm messageapi npm run db:migrate
```
### Tests
```sh
$ docker-compose run --rm messageapi npm run integration
$ docker-compose run --rm messageapi npm run test
```
