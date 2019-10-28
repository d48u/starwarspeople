
# Star Wars People API

**Recruitment task**

Your task is to:
- placing the Laravel application instance,
- query https://swapi.co/ to download 100 people and save to the database,
- issuing an endpoint that will allow you to download the selected person by their 'name',
- verifying that the API questioner is using the correct token.

https://swapi.co/ The Star Wars API

* Laravel Framework 6.4.0
* Laravel Passport

## Install

```
composer install
```

## .env

Set
```
DB_CONNECTION=sqlite
```

Set
```
DB_DATABASE={your_path}/database/database.sqlite 
```

or comment the DB_DATABASE
```
#DB_DATABASE=laravel
```

1. Create database
```
touch database/database.sqlite
```

2. Migrate
```
php artisan migrate
```

3. Gets data about people from swapi.co and save to database
```
php artisan get:people 
```

or

Database seed 100 fake people
```
php artisan db:seed --class=PeopleTableSeeder
```

4. Generate Encryption keys (personal and grand clients) 

```
php artisan passport:install
```

```
php artisan passport:keys
```

5. People API test (register, login, show person)

```
tests/Feature/PeopleTest.php
```

run
```
vendor/bin/phpunit
```

## API
**Note:** no CORS

[Run in Postman](https://documenter.getpostman.com/view/9284827/SVzxagP1?version=latest)


### Register

POST `/api/v1/register/`

**Headers**
```
Accept	application/json
```

**Body formdata example**
```
name	John Doe
email	john@example.com
password	testing
c_password	testing
```

**Response**

```json
{
    "success": true,
    "data": {
        "token": "eyJ0eXAiOiJKV ... ",
        "name": "John Doe"
    },
    "message": "User register successfully."
}
```

### Login
POST `api/v1/login`

**Headers**
```
Accept	application/json
```

**Body formdata example**
```
email	john@example.com
password	testing
```

**Response**

```json
{
    "success": true,
    "data": {
        "token": "eyJ0eXAiOiJKV ... ",
        "name": "John Doe"
    },
    "message": "User login successfully."
}
```

### Show person
POST `api/v1/people/person`

**Headers**
```
Accept	application/json
Authorization	Bearer {token}
Content-Type    application/x-www-form-urlencoded
```

**Body formdata example**
```
name	Luke Skywalker
```

**Response**

```json
{
    "success": true,
    "data": {
        "id": 288,
        "name": "Luke Skywalker",
        "data": {
            "name": "Luke Skywalker",
            "height": "172",
            "mass": "77",
            "hair_color": "blond",
            "skin_color": "fair",
            "eye_color": "blue",
            "birth_year": "19BBY",
            "gender": "male",
            "homeworld": "https://swapi.co/api/planets/1/",
            "films": [
                "https://swapi.co/api/films/2/",
                "https://swapi.co/api/films/6/",
                "https://swapi.co/api/films/3/",
                "https://swapi.co/api/films/1/",
                "https://swapi.co/api/films/7/"
            ],
            "species": [
                "https://swapi.co/api/species/1/"
            ],
            "vehicles": [
                "https://swapi.co/api/vehicles/14/",
                "https://swapi.co/api/vehicles/30/"
            ],
            "starships": [
                "https://swapi.co/api/starships/12/",
                "https://swapi.co/api/starships/22/"
            ],
            "created": "2014-12-09T13:50:51.644000Z",
            "edited": "2014-12-20T21:17:56.891000Z",
            "url": "https://swapi.co/api/people/1/"
        },
        "created_at": "27/10/2019",
        "updated_at": "27/10/2019"
    },
    "message": "Person retrieved successfully."
}
```
