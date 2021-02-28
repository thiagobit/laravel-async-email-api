# Async Email API

An API done in Laravel 8.29.0 for sending asynchronous emails.

## Requirements
- [Docker](https://docs.docker.com/engine/install/).
- [Docker Compose](https://docs.docker.com/compose/install/).

## Authentication

The API works with JWT authentication.
Token needs to be sent in `api_token` parameter.

## Methods

### api/list
- Endpoint: http://localhost:8080/api/list
- Description: List all sent emails with downloadable attachments.
- Method: `GET`
- Needs Authentication: `true`
- Parameters:
- Example:
  - Input:
    ```
    ```
  - Output:
    ```json
    [
      {
        "email": "me@me.com",
        "subject": "My Subject",
        "body": "<html><body><h1>My message.</h1></body></html>",
        "attachments": [
          {
            "url": "http://127.0.0.1:8000/storage/foo.jpg"
          }
        ]
      },
      {
        "email": "you@you.com",
        "subject": "Your Subject",
        "body": "<html><body><h1>Your message.</h1></body></html>",
        "attachments": [
          {
            "url": "http://127.0.0.1:8000/storage/foo.jpg"
          },
          {
            "url": "http://127.0.0.1:8000/storage/bar.jpeg"
          },
        ]
      },
      {
        "email": "we@we.com",
        "subject": "Our Subject",
        "body": "<html><body><h1>Our message.</h1></body></html>",
        "attachments": []
      }
    ]
    ```

### api/send
- Endpoint: http://localhost:8080/api/send
- Description: Send email to the queue.
- Method: `POST`
- Needs Authentication: `true`
- Parameters:
  - `emails`
    - Description: List of emails to be sent.
    - Type: `array`
  - `email`
    - Description: Email address of the receiver.
    - Type: `string`
  - `subject`
    - Description: Subject of the message.
    - Type: `string`
  - `body`
    - Description: Content of the message.
    - Type: `string`
  - `attachments`
    - Description: List of attachments.
    - Type: `array`
  - `name`
    - Description: Name of the attached file.
    - Type: `string`
  - `file`
    - Description: Content of the attached file.
    - Type `base64`
- Example:
  - Input:
  ```json
  {
    "emails": [
      {
        "email": "me@me.com",
        "subject": "My Subject",
        "body": "<html><body><h1>My message.</h1></body></html>",
        "attachments": [
          {
            "name": "[name of the file]",
            "file": "[base64 representation of the file]"
          }
        ]
      },
      {
        "email": "you@you.com",
        "subject": "Your Subject",
        "body": "<html><body><h1>Your message.</h1></body></html>",
        "attachments": [
          {
            "name": "[name of the file]",
            "file": "[base64 representation of the file]"
          },
          {
            "name": "[name of the file]",
            "file": "[base64 representation of the file]"
          }
        ]
      },
      {
        "email": "we@we.com",
        "subject": "Our Subject",
        "body": "<html><body><h1>Our message.</h1></body></html>",
        "attachments": []
      }
    ]
  }
  ```
  - Output:
  ```
  ```
  
---
#### P.S.: Do not forget to add `Accept: application/json` in the `Header` of your requisitions.

---

## Installation
1. Clone this repository:
```shell
git clone git@github.com:thiagobit/async-email-api.git
```

2. Create .env file:
```shell
cp .env_example .env
```

3. Run docker-compose:
```shell
docker-compose up
```

## Access
- Horizon: http://localhost:8080/horizon  
- MySQL: `docker exec -it laravel-async-email-api_mysql mysql -uroot`  
- Redis: `docker exec -it laravel-async-email-api_redis redis-cli`

## Extras
- Creating API Users:
  1. Enter in PHP docker container:
    ```shell
    docker exec -it laravel-async-email-api_php sh
    ```
  
  2. Run Tinker:
    ```shell
    php artisan tinker
    ```
  
  3. Inside Tinker, create how many users you want:
    ```
    User::factory()->count(1)->create();
    ```
  
- Running tests:
  ```shell
  docker exec -it laravel-async-email-api_php vendor/phpunit/phpunit/phpunit
  ```
  
- For email test I recomment [Mailtrap](https://mailtrap.io/), it's really easy to use and configure.
